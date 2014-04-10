<?php

namespace Tele\ComBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Tele\ComBundle\Data\PhoneNumberData;
use Tele\ComBundle\Entity\Customer;
use Tele\ComBundle\Entity\PhoneNumber;
use Tele\ComBundle\Exception\EntityNotFoundException;
use Tele\ComBundle\Repository\CustomerRepository;

use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use JMS\DiExtraBundle\Annotation as Di;
use Tele\ComBundle\Repository\PhoneNumberRepository;

class CustomerController extends FOSRestController
{

    /**
     * @var CustomerRepository
     */
    protected $customerRepository;

    /**
     * @var PhoneNumberRepository
     */
    protected $phoneNumberRepository;

    /**
     * @var FormFactory
     */
    protected $formFactory;


    /**
     * @Di\InjectParams({
     *     "customerRepository" = @Di\Inject("telecom.repository.customer"),
     *     "phoneNumberRepository" = @Di\Inject("telecom.repository.phone_number"),
     *     "formFactory" = @Di\Inject("form.factory")
     * })
     */
    public function __construct(CustomerRepository $customerRepository, PhoneNumberRepository $phoneNumberRepository,
                                FormFactory $formFactory)
    {
        $this->customerRepository    = $customerRepository;
        $this->phoneNumberRepository = $phoneNumberRepository;
        $this->formFactory           = $formFactory;
    }

    /**
     * @Rest\Get("/{id}", name = "customer_get")
     * @Rest\View()
     * @ApiDoc(description = "Returns a customer object with his phone numbers by id")
     */
    public function getAction($id)
    {
        return $this->customerRepository->get($id);
    }

    /**
     * @Rest\Put("/{id}", name = "customer_update")
     * @ApiDoc(
     *     description = "Updates a customer",
     *     parameters = {
     *         { "name" = "name", "dataType" = "text", "required" = true }
     *     }
     * )
     */
    public function updateAction($id, Request $request)
    {
        $customer = $this->customerRepository->get($id);

        $form = $this->formFactory->createNamed("", "telecom_customer", $customer);

        if ($form->submit($request)->isValid()) {
            $this->customerRepository->updateCustomer($customer);

            return $this->view($customer, 200);
        } else {
            return $this->view(["errors" => $form->getErrors()], 400);
        }
    }

    /**
     * @Rest\Get("/", name = "customer_list")
     * @Rest\View()
     * @ApiDoc(description = "Returns a list of all customers")
     */
    public function listAction()
    {
        return $this->customerRepository->findAll();
    }

    /**
     * @Rest\Post("/", name = "customer_create")
     * @ApiDoc(
     *    description = "Creates new customer",
     *    parameters = {
     *        { "name" = "name", "dataType" = "text", "required" = true }
     *    }
     * )
     */
    public function createAction(Request $request)
    {
        $customer = new Customer();

        $form = $this->get("form.factory")->createNamed("", "telecom_customer", $customer);

        if ($form->submit($request)->isValid()) {
            $this->customerRepository->addCustomer($customer);

            return $this->view(null, 201, [
                "Location" => $this->generateUrl("customer_get", ["id" => $customer->getId()])
            ]);
        } else {
            return $this->view(["errors" => $form->getErrors()], 400);
        }
    }

    /**
     * @Rest\Post("/{id}/phone", name = "customer_add_phone_number")
     * @ApiDoc(
     *    description = "Adds new phone number to the customer",
     *    parameters = {
     *        { "name" = "number", "dataType" = "text", "required" = true },
     *        { "name" = "active", "dataType" = "boolean", "required" = true }
     *    }
     * )
     */
    public function addPhoneNumberAction($id, Request $request)
    {
        $customer = $this->customerRepository->get($id);
        $data = new PhoneNumberData();

        // NOTE: I think phoneNumber->number must be immutable so I use data-object here
        $form = $this->formFactory->createNamed("", "telecom_phone_number", $data);

        if ($form->submit($request)->isValid()) {
            $phoneNumber = new PhoneNumber($data->number, $data->active, $customer);
            $this->customerRepository->updateCustomer($customer);

            return $this->view(null, 201, [
                "Location" => $this->generateUrl("customer_get_phone_number",
                        ["id" => $customer->getId(), "phoneNumberId" => $phoneNumber->getId()])
            ]);
        } else {
            return $this->view(["errors" => $form->getErrors()], 400);
        }
    }

    /**
     * @Rest\Patch("/{id}/phone/{phoneNumberId}", name = "customer_update_phone_number")
     * @ApiDoc(
     *     description = "Updates phone number for given customer",
     *     parameters = {
     *         { "name" = "active", "dataType" = "boolean", "required" = true }
     *     }
     * )
     */
    public function updatePhoneNumberAction($id, $phoneNumberId, Request $request)
    {
        $phoneNumber = $this->phoneNumberRepository->get($phoneNumberId);

        if ($phoneNumber->getCustomer()->getId() !== (int)$id) {
            throw new EntityNotFoundException();
        }

        $form = $this->formFactory->createNamed("", "telecom_phone_number_update", $phoneNumber);

        if ($form->submit($request)->isValid()) {
            $this->phoneNumberRepository->updatePhoneNumber($phoneNumber);

            return $this->view($phoneNumber, 200);
        } else {
            return $this->view(["errors" => $form->getErrors()], 400);
        }
    }

    /**
     * @Rest\Get("/{id}/phone/{phoneNumberId}", name = "customer_get_phone_number")
     * @ApiDoc(description = "Returns phone number object")
     * @Rest\View()
     */
    public function getPhoneNumberAction($id, $phoneNumberId)
    {
        $phoneNumber = $this->phoneNumberRepository->get($phoneNumberId);

        if ($phoneNumber->getCustomer()->getId() !== (int)$id) {
            throw new EntityNotFoundException();
        }

        return $phoneNumber;
    }

}
