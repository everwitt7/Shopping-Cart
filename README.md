# README #

330 Creative Project:
For our creative project we will make a website that people can register as either a customer or supplier. Suppliers will be able to add inventory for sale, and customers will be able to add items from different suppliers to a shopping cart. We will implement React and Twilio in this project, and plan to make the site a simplified version of eBay or amazon.


Learning Things (20 points)
- React/Twilio Tutorial (8 points)
- React installation and set up (6 points)
- Twilio API account set up (6 points)
(20)
Customer/Supplier Creation and Profiles (18 points)
- C/S can register (4 points)
- C/s can login/log out (4 points)
- Passwords are hashed, salted, and checked securely (4 points)
(38)
Customer Functionality (20 points)
- User can add an item to shopping cart (5 points)
- User can remove item from cart (5 points)
- User can add item to save for later (5 points)
- User can checkout shopping cart (5 points)
(58)
Supplier Functionality (25 points)
- Supplier can post an item to sell (5 points)
- Supplier can add description (5 points)
- Supplier can edit what they are selling (5 points)
- Supplier gets a text notification when product is purchased (5 points)
- Supplier can look at data of who bough what items (5 points)
(83)
Best Practices (12 points)
- Code is well formatted, readable, and commented (4 points)
- Code passes HTML validation (2 points)
- Safe from XSS attacks (4 points)
- Site is visually appealing (2 points)
(95)
Getting Approved by a TA and submitting on time (5 points)
Approved by Alex Weil
(100)


# Learning Things #
We used both react and twilio in our website. We used twilio in order to send a message to
a buyer and seller when a buyer checks out (sends to buyer) and sends a message to the seller
an item that the buyer checked out was an item that he was selling (sends to seller).

# Customer/Supplier Creation and Profiles #
Can register as both a buyer or a seller and log in successfully. Both users can log in and
log out successfully and we store the passwords of both users salted hashed.

# Customer Functionality #
Buyers can add items to shopping carts successfully, they can add items to saved items
and they can remove those items from their shopping carts and saved items if they want
to. If a buyer checks out, the items that he purchased are removed from the available items
for sale, other users shopping carts, and other users saved items. A text message is then
sent to the buyer that his checkout was successful and to the seller that his item was purchased

# Supplier Functionality #
Suppliers can post items to sell and add a description to those items. The supplier can remove
items that they have listed for sale. We decided that remove and synonymous would be the same
because if a customer edits what he is selling to something else and it is someone's cart it will update,
and the customer might not want that so we considered edit to be removed, that way both parties
would be satisfied. Thus, if a seller wants to post a new item and remove an old item they should have
to just remove the old item then add the new item, which is what we implemented. The seller gets a
message when a buyer checks out one of their items saying that an item was purchased and then the
supplier can look through all of the items that were purchased to get information on what buyers are
buying what, and maybe what products they like and would want to buy in the future

# Best Practices #
Self explanatory
