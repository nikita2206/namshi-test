TeleCom API
===========

The API overview can be seen on this screenshot:

![screenshot](https://dl.dropboxusercontent.com/u/3482331/Screenshot%20from%202014-04-10%2015%3A36%3A43.png)

As you can see I didn't create a direct `/phone` endpoint because I think phone numbers belong to customers
so you can't just get all phone numbers. But if you want to, you can get all customers and iterate through
the `phones` array.

There's some problems with ApiDoc's sandbox (it seems as it wont send Accept header when redirected) that's why
you can get random "Template not found" messages. I already send submitted this with the delay of one day (from your email)
so I didn't want to spend more time on that.
