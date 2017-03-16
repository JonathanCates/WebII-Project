// JavaScript File
$(function () {
    
    $("select").change(function()
    {
        var itemNum = $(this).attr("itemNum");
        var baseCost = parseInt($("#painting"+itemNum).attr("price"));
        var quantity = parseInt($("#quantity"+itemNum).attr("value"));
        var frameCost = parseInt($("#frame"+itemNum).find(":selected").attr("price"));
        var glassCost = parseInt($("#glass"+itemNum).find(":selected").attr("price"));
        
        var mattID = $("#matt"+itemNum).find(":selected").attr("value");
        if(mattID == 35)
        {
            var mattCost = 0;
        }
        else
        {
            mattCost = 10;
        }
        var itemCost = (baseCost + frameCost + glassCost + mattCost) * quantity;
        $('#itemTotal'+itemNum).attr('value', itemCost).html("$"+itemCost);
        
        subTotal();
        calculateShipping();
        grandTotal();
    });
    
    $("input[type=number]").on("input", function()
    {
        if(!$.isNumeric($(this).val()) || $(this).val() < 1)
        {
            alert("Please input a value greater than 0 or remove using botton on left of image");
        }
        else
        {
            var itemNum = $(this).attr("itemNum");
            $("#quantity"+itemNum).attr("value", $(this).val());
            var baseCost = parseInt($("#painting"+itemNum).attr("price"));
            var quantity = parseInt($("#quantity"+itemNum).attr("value"));
            var frameCost = parseInt($("#frame"+itemNum).find(":selected").attr("price"));
            var glassCost = parseInt($("#glass"+itemNum).find(":selected").attr("price"));
            
            var mattID = $("#matt"+itemNum).find(":selected").attr("value");
            if(mattID == 35)
            {
                var mattCost = 0;
            }
            else
            {
                mattCost = 10;
            }
            var itemCost = (baseCost + frameCost + glassCost + mattCost) * quantity;
            $('#itemTotal'+itemNum).attr('value', itemCost).html("$"+itemCost);
            
            subTotal();
            calculateShipping();
            grandTotal();
        }
    });
    
    $("input[name=shipping]:radio").change(function () 
    {
        var grandTotal = parseInt($('#subTotal').attr('value')) + parseInt($(this).val());
        $('#grandTotal').attr('value', grandTotal).html('$' + grandTotal);
    });
    
    function subTotal()
    {
        var subTotal = 0;
        $('h4[name="itemCost"]').each(function()
        {
            subTotal += parseInt($(this).attr("value"));
        });
        $("#subTotal").attr("value", subTotal).html("$"+subTotal);
    }
    
    function calculateShipping()
    {
        var totalQuantity=0;
        var subTotal = parseInt($("#subTotal").attr("value"));
        $('input[name="quantity"').each(function()
        {
            totalQuantity += parseInt($(this).attr("value"));
        });
        if(subTotal > 1500)
        {
            $("#standardShipping").attr("value", 0);
            $("#standardShippingMessage").html("Standard Shipping Cost: FREE");
            if(subTotal > 2500)
            {
                $("#expressShipping").attr("value", 0);
                $("#expressShippingMessage").html("Express Shipping Cost: FREE");
            }
            else
            {
               $("#expressShipping").attr("value", totalQuantity * 50);
               $("#expressShippingMessage").html("Express Shipping Cost: $"+(totalQuantity * 50));
            }
        }
        else
        {
            $("#standardShipping").attr("value", totalQuantity * 25);
            $("#standardShippingMessage").html("Standard Shipping Cost: $"+(totalQuantity * 25));
            $("#expressShipping").attr("value", totalQuantity * 50);
            $("#expressShippingMessage").html("Express Shipping Cost: $"+(totalQuantity * 50));
        }
    }
    
    function grandTotal()
    {
        var grandTotal = parseInt($('#subTotal').attr('value')) + parseInt($('input[name=shipping]').val()); 
        $('#grandTotal').attr('value', grandTotal).html('$'+grandTotal);
    }
});