<!DOCTYPE html>
<html>

<head>
    <title>How to create a multi-step wizard form in PHP</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/wizard/style.css');?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/wizard/form.css');?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/wizard/wizard.css');?>" />
</head>

<body>
    <div class="phppot-container">
        <h1>How to create a multi-step wizard form in PHP</h1>

        <form method="POST" id="checkout-form" onSubmit="return validateCheckout()">
            <div class="wizard-flow-chart">
                <span class="fill">1</span>
                <span>2</span>
                <span>3</span>
                <span>4</span>
            </div>
            <?php if (isset($message)) { ?>
                <div class="message <?php echo $type; ?>"><?php echo $message; ?></div>
            <?php } ?>
            <!-- Wizard section 1 -->
            <section id="billing-section">
                <h3>Billing details</h3>
                <div class="row">
                    <label class="float-left label-width">Name</label>
                    <input name="customer_billing_name" type="text">
                </div>
                <div class="row">
                    <label class="float-left label-width">Email</label>
                    <input name="billing_email" type="text">
                </div>
                <div class="row">
                    <label class="float-left label-width">State</label>
                    <input name="billing_state" type="text">
                </div>
                <div class="row">
                    <label class="float-left label-width">City</label>
                    <input name="billing_city" type="text">
                </div>
                <div class="row">
                    <label class="float-left label-width">Country</label>
                    <input name="billing_country" type="text">
                </div>
                <div class="row">
                    <label class="float-left label-width">Zip</label>
                    <input name="billing_zipcode" type="text">
                </div>
                <div class="row button-row">
                    <button type="button" onClick="validate(this)">Next</button>
                </div>
            </section>

            <!-- Wizard section 2 -->
            <section id="shipping-section" class="display-none">
                <h3>Shipping details</h3>
                <div class="row">
                    <label class="float-left label-width">Name</label>
                    <input name="customer_shipping_name" type="text">
                </div>
                <div class="row">
                    <label class="float-left label-width">Email</label>
                    <input name="shipping_email" type="text">
                </div>
                <div class="row">
                    <label class="float-left label-width">State</label>
                    <input name="shipping_state" type="text">
                </div>
                <div class="row">
                    <label class="float-left label-width">City</label>
                    <input name="shipping_city" type="text">
                </div>
                <div class="row">
                    <label class="float-left label-width">Country</label>
                    <input name="shipping_country" type="text">
                </div>
                <div class="row">
                    <label class="float-left label-width">Zip</label>
                    <input name="shipping_zipcode" type="text">
                </div>
                <div class="row button-row">
                    <button type="button" onClick="showPrevious(this)">Previous</button>
                    <button type="button" onClick="validate(this)">Next</button>
                </div>
            </section>


            <!-- Wizard section 3 -->
            <section id="discount-section" class="display-none">
                <h3>Apply discount:</h3>
                <div class="row"><label>Coupon code</label>
                    <input name="discount_coupon" type="text" onClick="validate(this)">
                </div>
                <div class="row button-row">
                    <button type="button" onClick="showPrevious(this)">Previous</button>
                    <button type="button" onClick="validate(this)">Next</button>
                </div>
            </section>

            <!-- Wizard section 4 -->
            <section id="others-section" class="display-none">
                <h3>Others:</h3>
                <div class="row">
                    <label>Notes</label>
                    <textarea name="notes" rows="4" cols="50" id="notes"></textarea>
                </div>
                <div class="row button-row">
                    <button type="button" onClick="showPrevious(this)">Previous</button>
                    <button type="submit">Checkout</button>
                </div>
            </section>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="<?php echo base_url('assets/js/wizard/wizard.js');?>"></script>
</body>

</html>