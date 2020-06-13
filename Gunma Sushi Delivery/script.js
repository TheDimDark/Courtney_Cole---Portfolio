function DisplayPopup(numberOfSushiOptions) 
{
    // Also prepare the order display
    var orderList = "";
    var finalCost = 0.00;
    for (i = 1; i <= numberOfSushiOptions; i++)
    {
        if ($("#number" + i).val() != 0 && $("#number" + i).val() != null)
        {
            var numberWanted = parseFloat($("#number" + i).val());
            var sushiName = $("#name" + i).html();
            if (numberWanted > 1)
            {
                sushiName += "s";
            }
            var sushiPrice = parseFloat($("#price" + i).html());
            var sushiPricing = numberWanted * sushiPrice;
            orderList += numberWanted + " " + sushiName + " * $" + sushiPrice.toFixed(2) + " = $" + sushiPricing.toFixed(2) + "<br>";
            finalCost += sushiPricing;
        }
    }

    // If the order is empty, don't display the order popup
    if (finalCost == 0.00)
    {
        var popup = document.getElementById("popupWarning");
        popup.style.display = "block";
    }
    else
    {
        $("#sushiordered").html(orderList);
        $("#orderCost").html("$" + finalCost.toFixed(2));

        var popup = document.getElementById("popupForm");
        popup.style.display = "block";
    }
}

function ClosePopup() 
{
    var popup = document.getElementById("popupForm");
    popup.style.display = "none";
}

function CloseWarningPopup() 
{
    var popup = document.getElementById("popupWarning");
    popup.style.display = "none";
}

function DisplayErrorPopup()
{
    var popup = document.getElementById("popupError");
    popup.style.display = "block";
}
function CloseErrorPopup() 
{
    var popup = document.getElementById("popupError");
    popup.style.display = "none";
}

function DisplayConfirmationPopup()
{
    var popup = document.getElementById("popupConfirmation");
    popup.style.display = "block";
}
function CloseConfirmationPopup() 
{
    var popup = document.getElementById("popupConfirmation");
    popup.style.display = "none";
    window.location.assign(window.location.href);
}

function CalculateSushiPricing(sushiID, price) 
{
    // Make sure we don't get unwanted input
    $("#number" + sushiID).val($("#number" + sushiID).val().replace(/\D/g,''));

    // Calculate the price
    if ($("#number" + sushiID).val() == 0 || $("#number" + sushiID).val() == null)
    {
        $("#totalPrice" + sushiID).html("0.00");
    }
    else
    {
        $("#totalPrice" + sushiID).html((parseFloat($("#number" + sushiID).val()) * price).toFixed(2));
    }
}

function ResetValues(numberOfSushiOptions) 
{
    for (i = 1; i < numberOfSushiOptions; i++)
    {
        $("#number" + i).val("");
    }
}

function CleanStateInput()
{
    // Make sure we don't get unwanted input
    $("#state").val($("#state").val().replace(/[^a-zA-Z]+/g,''));
}

function CleanZipInput()
{
    // Make sure we don't get unwanted input
    $("#zip").val($("#zip").val().replace(/\D/g,''));
}

/* -------------------------------------------------------------------------------------------------------------------------------------- */

/* Below content is specifically for the Order Handler page */

function RefreshView() 
{
    window.location.assign(window.location.href);
}