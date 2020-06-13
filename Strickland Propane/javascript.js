/*
    Javascript for the home page...
*/

// An array to store each image that appears on the home page
var homeImages = new Array ("homeImages/strickland.jpg", 
                            "homeImages/bbq.jpg",
                            "homeImages/truck.jpg",
                            "homeImages/stove.jpg",
                            "homeImages/residential.jpeg");
// The original source index for the first picture we want to display
var sourceIndex = 0;

// Cycle through the images on the home page
function changeImage(side)
{
    // Find the image on the home page to be changed
    var homeImage = document.getElementById("homeImage");

    // Calculate which image to bring up according to the button pushed
    if (side == 'L')
    {
        // The left button was pushed, so cycle that direction
        if (sourceIndex == 0)
        {
            sourceIndex = homeImages.length - 1;
        }
        else
        {
            sourceIndex--;
        }
    }
    else if (side == 'R')
    {
        // The right button was pushed, so cycle that direction
        if (sourceIndex == homeImages.length - 1)
        {
            sourceIndex = 0;
        }
        else
        {
            sourceIndex++;
        }
    }

    // Replace the image on the source page with the one we jsut determined
    var source = homeImages[sourceIndex];
    homeImage.src = source;
}

/*
    Javascript for the products page...
*/

// An array of objects to store the various products and their information
var products = new Array();
// Push all the objects we need into the array
    // The grills
var vognerCamper = {name: "The Vogner Camper", type: "GRILL", price: 59.99, image: "productImages/vognerCamper.jpg", description: "A small, propane-powered grill for portable use. Great for hotdogs!"};
products.push(vognerCamper);
var vognerTrainer = {name: "The Vogner Trainer", type: "GRILL", price: 109.99, image: "productImages/vognerTrainer.jpg", description: "Great for apartments and beginner grill-masters. Get a taste of the meat with this small propane grill."};
products.push(vognerTrainer);
var vognerCitizen = {name: "The Vogner Citizen", type: "GRILL", price: 129.99, image: "productImages/vognerCitizen.jpg", description: "Want to grill, but not sure if you want to invest yet? This is the grill for you. Great for smoking a pair of ribs on a hot summer day."};
products.push(vognerCitizen);
var vognerCharKing = {name: "The Vogner Char-King", type: "GRILL", price: 189.99, image: "productImages/vognerCharKing.jpg", description: "Our best-seller. You aren't a real Texas man without a grill like this!"};
products.push(vognerCharKing);
var charKingImperiale = {name: "The Char-King Imperiale", type: "GRILL", price: 259.99, image: "productImages/charKingImperiale.jpg", description: "A top-of-the-line model, the Imperiale will see to all of your needs, and is recommended by all of our staff for your purchase."}
products.push(charKingImperiale);
var charKingPrestige = {name: "The Char-King Prestige", type: "GRILL", price: 399.99, image: "productImages/charKingPrestige.jpg", description: "This grill screams class. Expect nothing less than prefection from this grill. It cooks, it smokes, and it's all propane-powered."}
products.push(charKingPrestige);
    // The tanks
var smallTank = {name: "Small Propane Tank", type: "TANK", price: 19.99, image: "productImages/smallTank.jpg", description: "A 20-pound steel tank containing 80 ounces of propane."};
products.push(smallTank);
var mediumTank = {name: "Medium Propane Tank", type: "TANK", price: 29.99, image: "productImages/mediumTank.jpg", description: "A 40-pound steel tank of 160 ounces of propane."};
products.push(mediumTank);
var smallTank = {name: "Large Propane Tank", type: "TANK", price: 39.99, image: "productImages/largeTank.jpg", description: "A 60-pound steel tank 320 ounces of propane."};
products.push(smallTank);
    // The merchandise
var longSleeveShirt = {name: "Unisex Long Sleeve", type: "MERCH", price: 34.99, image: "productImages/longSleeve.jpg", description: "A long sleeve shirt for grilling in the cold.\nComes in sizes S, M, L, and XL."};
products.push(longSleeveShirt);
var oldLogoShirt = {name: "Unisex Retro Tee", type: "MERCH", price: 29.99, image: "productImages/oldFashioned.jpg", description: "A classic unisex shirt with our classic logo.\nComes in sizes S, M, L, and XL."};
products.push(oldLogoShirt);
var shortSleeveShirt = {name: "Unisex Propane Tee", type: "MERCH", price: 29.99, image: "productImages/blackTee.jpg", description: "A unisex tee featuring a several propane tanks.\nComes in sizes S, M, L, and XL."};
products.push(shortSleeveShirt);
var mensShirt = {name: "Men's Strickland Tee", type: "MERCH", price: 24.99, image: "productImages/mensShirt.png", description: "A men's shirt featuring a slick logo.\nComes in sizes S, M, L, and XL."};
products.push(mensShirt);
var ladiesShirt = {name: "Woman's Strickland Tee", type: "MERCH", price: 24.99, image: "productImages/ladiesShirt.jpeg", description: "A women's shirt featuring a slick logo.\nComes in sizes S, M, L, and XL."};
products.push(ladiesShirt);
    // Misc. Products
var tankSetter = {name: "Tank Setter", type: "MISC", price: 14.99, image: "productImages/tankSetter.jpg", description: "A stand for your Strickland-supplied propane tank.\nSupports all non-industial tanks."};
products.push(tankSetter);
var propaneRegulator = {name: "Propane Regulator", type: "MISC", price: 9.99, image: "productImages/propaneRegulator.jpg", description: "A gauge to check the amount of Strickland propane you have left in your tank."};
products.push(propaneRegulator);

// Reset the search bar
function resetSearch()
{
    // Get the pieces of the search bar
    var searchText = document.getElementById("productName");
    var searchType = document.getElementById("productType");
    var searchPrice = document.getElementById("priceOrder");

    // Restore the default settings for the search bar
    searchText.value = "";
    searchType.value = "ALL";
    searchPrice.value = "ASC";
}

// Show the search generated by the values of the search bar
function displaySearch()
{
    // Get the pieces of the search bar
    var searchText = document.getElementById("productName");
    var searchType = document.getElementById("productType");
    var searchPrice = document.getElementById("priceOrder");

    // Take in the values from the search bar
    var userSearchText = searchText.value.toUpperCase();
    var userSearchType = searchType.value;
    var userSearchPrice = searchPrice.value;

    // Create an array that will store the products we want to display
    var productCards = new Array();

    // Check all of our products
    for (var i = 0; i < products.length; i++)
    {
        // Check if the product name contains the string searched for by the user
        if (products[i].name.toUpperCase().includes(userSearchText) == false)
        {
            // Skip this one, since we don't care about it.
            continue;
        }

        // Check if we need to look for products by type
        if (userSearchType != "ALL")
        {
            // Check if the product type is the same as what is specified by the user
            if (products[i].type != userSearchType)
            {
                // Skip this one, since we don't care about it.
                continue;
            }
        }

        // If it made it down here, add the product card to the search output
        productCards.push(products[i])
    }

    // Sort the output by the price order given by the user
    if (userSearchPrice == "ASC")
    {
        productCards.sort((a, b) => (a.price > b.price) ? 1 : -1)
    }
    else if (userSearchPrice == "DESC")
    {
        productCards.sort((a, b) => (a.price < b.price) ? 1 : -1)
    }

    // Prepare the block to have a new search by clearing out the previous one
    var productsSpot = document.getElementById("productsSpot");
    productsSpot.innerHTML = "";

    // Output the information in the array
    for (var j = 0; j < productCards.length; j++)
    {
        // Turn the object into a product card and output it
        var cardInfo = "<div class = \"card\">";
        cardInfo += "<div> <img class = \"cardImage\" src = \"" + productCards[j].image + "\"> </div>";
        cardInfo += "<div class = \"cardInfo\"> <h2>" + productCards[j].name +"</h2>";
        cardInfo += "<div class = \"cardDescription\"> <p>" + productCards[j].description + "</p> </div>";
        cardInfo += "<h1> $" + productCards[j].price +"</h1> </div>";
        cardInfo += "</div>";
        productsSpot.innerHTML += cardInfo;
    }
}

/*
    Javascript for the orders page...
*/

// A function used to make it easy to enter the phone number
function managePhoneNumber(numBoxName, newFocus, oldFocus)
{
    // Get information on the box the user is currently tyling in
    var numBox = document.getElementById(numBoxName);
    var maxLength = numBox.maxLength;
    var text = numBox.value;
    var newNum = text.charAt(text.length - 1);

    // Make sure the number is, in fact, a number
    if ((newNum <= '0' || newNum >= '9') && numBox.value.length != 0)
    {
        // It isn't a number, so disallow the user from entering it
        numBox.value = text.slice(0, text.length - 1);
        return;
    }

    // Check if the current box is full or empty
    if (numBox.value.length == maxLength)
    {
        // Since it is, proceed to the next box
        document.getElementById(newFocus).focus();
    }
    else if (numBox.value.length == 0)
    {
        // Since it is, move back to the previous box
        var back = document.getElementById(oldFocus);
        back.focus();

        // Ensure that the cursor is at the end of the input
        var length = back.value.length;
        back.setSelectionRange(length, length);
    }
}

// A function to clear the form
function clearForm()
{
    // Clear all of the inputs in the order form
    document.getElementById("fullName").value = "";
    document.getElementById("address").value = "";
    document.getElementById("email").value = "";
    document.getElementById("phoneNumber1").value = "";
    document.getElementById("phoneNumber2").value = "";
    document.getElementById("phoneNumber3").value = "";
    document.getElementById("orderType").value = "NONE";
    document.getElementById("additionalInfo").value = "";

    // Remove all the required flags
    document.getElementById("nameRequired").innerHTML = "";
    document.getElementById("addressRequired").innerHTML = "";
    document.getElementById("emailRequired").innerHTML = "";
    document.getElementById("phoneRequired").innerHTML = "";
    document.getElementById("typeRequired").innerHTML = "";
    document.getElementById("noteRequired").innerHTML = "";

    // Removed the form-submitted text
    document.getElementById("submissionInfo").innerHTML = "";
}

// Check that the user meets all of the requirements when submitting
function checkRequirements()
{
    // Get all of the inputs in the order form
    var fullName = document.getElementById("fullName");
    var address = document.getElementById("address");
    var email = document.getElementById("email");
    var phoneNumber1 = document.getElementById("phoneNumber1");
    var phoneNumber2 = document.getElementById("phoneNumber2");
    var phoneNumber3 = document.getElementById("phoneNumber3");
    var orderType = document.getElementById("orderType");
    var additionalInfo = document.getElementById("additionalInfo");

    // Take in all the values from the inputs
    var contactName = fullName.value;
    var contactAddress = address.value;
    var contactEmail = email.value.toLowerCase();
    var contactNum1 = phoneNumber1.value;
    var contactNum2 = phoneNumber2.value;
    var contactNum3 = phoneNumber3.value;
    var orderTopic = orderType.value;
    var orderNotes = additionalInfo.value;

    // Make sure that they entered a name
    var nameEntered = false;
    if (contactName == "")
    {
        // Since they didn't enter anything... Mark it as required
        document.getElementById("nameRequired").innerHTML = "* REQUIRED";
    }
    else
    {
        // Store that the name has been entered
        document.getElementById("nameRequired").innerHTML = "";
        nameEntered = true;
    }

    // Make sure that they entered an address
    var addressEntered = false;
    if (contactAddress == "")
    {
        // Since they didn't enter anything... Mark it as required
        document.getElementById("addressRequired").innerHTML = "* REQUIRED";
    }
    else
    {
        // Store that the address has been entered
        document.getElementById("addressRequired").innerHTML = "";
        addressEntered = true;
    }

    // Make sure that they entered an email
    var emailEntered = false;
    if (contactEmail == "")
    {
        // Since they didn't enter anything... Mark it as required
        document.getElementById("emailRequired").innerHTML = "* REQUIRED";
    }
    else
    {
        // Store that the email has been entered
        document.getElementById("emailRequired").innerHTML = "";
        emailEntered = true;
    }

    // Make sure they entered a phone number
    var phoneEntered = false;
    var contactPhoneNumber = "";
    if (contactNum1.length != 3 || contactNum2.length != 3 || contactNum3.length != 4)
    {
        // Since they didn't do it right... Mark it as required
        document.getElementById("phoneRequired").innerHTML = "* REQUIRED";
    }
    else
    {
        // The number is correct, so store it
        document.getElementById("phoneRequired").innerHTML = "";
        phoneEntered = true;
        contactPhoneNumber = "+1 (" + contactNum1 + ") " + contactNum2 + "-" + contactNum3;
    }

    // Make sure they selected an order topic
    var topicEntered = false;
    if (orderTopic == "NONE")
    {
        // Since they didn't enter anything... Mark it as required
        document.getElementById("typeRequired").innerHTML = "* REQUIRED";
    }
    else
    {
        // Store that the type has been entered
        document.getElementById("typeRequired").innerHTML = "";
        topicEntered = true;
    }

    // If the topic entered is OTHER, then there must be additional information
    orderNotesEntered = false;
    if (orderTopic == "OTHER")
    {
        // Check if the user ahs entered any notes
        if (orderNotes == "")
        {
            // Since they didn't enter anything... Mark it as required
            document.getElementById("noteRequired").innerHTML = "* REQUIRED";
        }
        else
        {
            // The did enter something, so that's okay
            document.getElementById("noteRequired").innerHTML = "";
            orderNotesEntered = true;
        }
    }
    else
    {
        // It isn't required, so we don't care
        document.getElementById("noteRequired").innerHTML = "";
        orderNotesEntered = true;
    }

    // Check if all requirements are met before submitting
    if (nameEntered == true && addressEntered == true && emailEntered == true && phoneEntered == true && topicEntered == true && orderNotesEntered == true)
    {
        // If so then submit
        submitForm(contactName, contactAddress, contactEmail, contactPhoneNumber, orderTopic, orderNotes);
    }
    else
    {
        var submissionInfo = document.getElementById("submissionInfo");
        submissionInfo.innerHTML = "";
    }
}

// A function to submit the form upon completion
function submitForm(contactName, contactAddress, contactEmail, contactPhoneNumber, orderTopic, orderNotes)
{
    // Output that the form has been submitted
    var submissionInfo = document.getElementById("submissionInfo");
    submissionInfo.innerHTML = "Work Order Submitted!";

    /* // For testing purposes, output the result to an alert
    var order = "Full Name:\n\t" + contactName + "\n";
    order += "Address:\n\t" + contactAddress + "\n";
    order += "Email:\n\t" + contactEmail + "\n";
    order += "Phone Number:\n\t" + contactPhoneNumber + "\n";
    order += "Order Type:\n\t" + orderTopic + "\n";
    order += "Additional Information:\n\t" + orderNotes + "\n";
    window.alert(order); */
}