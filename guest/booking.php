<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Booking | The Royal Suites</title>

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<style>
body{
    margin:0;
    font-family:Arial, sans-serif;
    background:#f4f4f4;
}

.breadcrumb-wrapper{
    width:100%;
    background:white;
    padding:20px 40px;
    box-sizing:border-box;
    box-shadow:0 2px 10px rgba(0,0,0,.08);
}

h2{
    text-align:center;
    margin-bottom:20px;
}

hr {
    display: block;
    background-color: rgba(0, 0, 0, 0.1);
    margin: 20px auto;
}

.field{
    margin-bottom:20px;
}

.row{
    display:flex;
    gap:15px;
}

.row .field{
    flex:1;
}

.breadcrumb{
    background:white;
    display:flex;
    align-items:center;
    justify-content:center;
}

.crumb{
    display:flex;
    flex-direction:column;
    align-items:center;
    gap:8px;
    color:#999;
    font-size:13px;
    font-weight:600;
    cursor:pointer;
    transition:.3s;
}

.crumb span{
    width:38px;
    height:38px;
    border-radius:50%;
    border:2px solid #d9d9d9;
    display:flex;
    justify-content:center;
    align-items:center;
    background:white;
    transition:.3s;
}

.crumb-line{
    flex:1;
    height:2px;
    background:#d9d9d9;
    margin:0 10px;
    margin-bottom:22px;
}

.crumb.active{
    color:#1d1d1d;
}

.crumb.active span{
    background:#1d1d1d;
    color:white;
    border-color:#1d1d1d;
}

.crumb.completed span{
    background:#c9a86a;
    border-color:#c9a86a;
    color:white;
}

.crumb.completed{
    color:#c9a86a;
}

label{
    display:block;
    margin-bottom:8px;
    font-weight:bold;
}

.dates-section{
    background:
        linear-gradient(
            rgba(0,0,0,.35),
            rgba(0,0,0,.35)
        ),
        url('../images/suites/booking0.jpg');
    background-size:cover;
    background-position:center;
    padding:80px 20px;
    height: 465px;
}

.dates-card{
    width:450px;
    max-width:95%;
    margin:auto;
    margin-top: 50px;
    background:white;
    padding:20px;
    border-radius:12px;
    box-shadow:
        0 10px 30px rgba(0,0,0,.15);
}

.booking-card{
    width:1000px;
    max-width:95%;
    margin:40px auto;
    background:white;
    padding:25px;
    border-radius:12px;
    box-shadow:
        0 5px 20px rgba(0,0,0,.1);
}

/* keep card above background */
/* .booking-card{
    position: relative;
    width: 500px;
    z-index: 1;
} */

input[type="text"],
input[type="number"]{
    width:100%;
    padding:12px;
    border:1px solid #ccc;
    border-radius:8px;
    box-sizing:border-box;
}

input[type="text"]{
    cursor:pointer;
}

.search-btn{
    width:100%;
    padding:14px;
    border:none;
    background:#28a745;
    color:white;
    font-size:16px;
    border-radius:8px;
    cursor:pointer;
}

.search-btn:hover{
    background:#218838;
}

.room-grid{
    display:grid;
    grid-template-columns:repeat(2, 1fr);
    gap:20px;
    margin-top:20px;
}

.room-card{
    background:white;
    border:1px solid #ddd;
    border-radius:12px;
    overflow:hidden;
    transition:.3s;
}

.room-card:hover{
    transform:translateY(-3px);
    box-shadow:0 5px 15px rgba(0,0,0,.1);
}

.room-card img{
    width:100%;
    height:180px;
    object-fit:cover;
}

.room-content{
    padding:15px;
}

.room-content h3{
    margin-top:0;
}

.capacity{
    color:#666;
    font-size:14px;
}

.room-btn{
    width:100%;
    margin-top:10px;
    padding:12px;
    border:none;
    background:#28a745;
    color:white;
    border-radius:6px;
    cursor:pointer;
}

.rate-card{
    border:1px solid #ddd;
    border-radius:10px;
    padding:15px;
    margin-bottom:15px;
}

.rate-option{
    margin-bottom:15px;
}

.rate-option label{
    display:flex;
    justify-content:space-between;
    cursor:pointer;
}

.addon-section{
    margin-top:25px;
}

.addon-item{
    margin:10px 0;
}

.continue-btn{
    width:100%;
    padding:12px;
    border:none;
    background:#007bff;
    color:white;
    border-radius:6px;
    cursor:pointer;
    margin-top:20px;
}

.service-row{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:12px 0;
    border-bottom:1px solid #eee;
}

.service-row button{
    padding:6px 12px;
    border:none;
    border-radius:6px;
    background:#28a745;
    color:white;
    cursor:pointer;
}

.back-btn{
    width:100%;
    padding:12px;
    border:none;
    background:#6c757d;
    color:white;
    border-radius:6px;
    cursor:pointer;
    margin-top:10px;
}

.back-btn:hover{
    background:#5a6268;
}
</style>
</head>
<body>

<div class="breadcrumb-wrapper">

    <div class="breadcrumb">

        <div class="crumb active" id="crumbDates" onclick="goToStep(0)">
            <span>1</span>
            Dates
        </div>

        <div class="crumb-line"></div>

        <div class="crumb" id="crumbCategories" onclick="goToStep(1)">
            <span>2</span>
            Categories
        </div>

        <div class="crumb-line"></div>

        <div class="crumb" id="crumbRates" onclick="goToStep(2)">
            <span>3</span>
            Rates
        </div>

        <div class="crumb-line"></div>

        <div class="crumb" id="crumbSummary" onclick="goToStep(3)">
            <span>4</span>
            Summary
        </div>

        <div class="crumb-line"></div>

        <div class="crumb" id="crumbDetails" onclick="goToStep(4)">
            <span>5</span>
            Details
        </div>

    </div>
</div>
    <div class="dates-section" id="datesContainer">
        <div class="dates-card">

            <!-- STEP 1 -->
            <div id="bookingSection">

                <h2>Check Availability</h2>

                <div class="field">
                    <label>Dates</label>
                    <input
                        type="text"
                        id="dateRange"
                        placeholder="Select dates"
                        readonly
                        required>
                </div>

                <hr> 

                <div class="row">

                    <div class="field">
                        <label>Adults</label>
                        <input type="number" id="adults" min="1" value="2">
                    </div>

                    <div class="field">
                        <label>Children (0-18)</label>
                        <input type="number" id="children" min="0" value="0">
                    </div>

                </div>

                <button
                    class="search-btn"
                    type="button"
                    onclick="showRooms()">
                    Next
                </button>

            </div>

            

        </div>
    </div>

    <div class="booking-card" id="mainContainer" style="display:none;">

        <!-- STEP 2 -->
            <div id="roomSection" style="display:none;">

                <h2>Choose a Room Category</h2>

                <div class="room-grid">

                    <div class="room-card">
                        <img src="../images/suites/suite0.jpg" alt="Standard Room">

                        <div class="room-content">
                            <h3>Standard Room</h3>

                            <p class="capacity">
                                👤 2 Adults
                            </p>

                            <p>
                                Comfortable room with queen-sized bed and basic amenities.
                            </p>

                            <button
                                class="room-btn"
                                type="button"
                                onclick="showRates('Standard Room')">
                                Select Room
                            </button>
                        </div>
                    </div>

                    <div class="room-card">
                        <img src="../images/suites/suite0.jpg" alt="Deluxe Room">

                        <div class="room-content">
                            <h3>Deluxe Room</h3>

                            <p class="capacity">
                                👤 2 Adults • 1 Child
                            </p>

                            <p>
                                Spacious room with balcony and city view.
                            </p>

                            <button
                                class="room-btn"
                                type="button"
                                onclick="showRates('Deluxe Room')">
                                Select Room
                            </button>
                        </div>
                    </div>

                    <div class="room-card">
                        <img src="../images/suites/suite0.jpg" alt="Family Suite">

                        <div class="room-content">
                            <h3>Family Suite</h3>

                            <p class="capacity">
                                👤 4 Guests
                            </p>

                            <p>
                                Ideal for families with separate living area.
                            </p>

                            <button
                                class="room-btn"
                                type="button"
                                onclick="showRates('Family Suite')">
                                Select Room
                            </button>
                        </div>
                    </div>

                    <div class="room-card">
                        <img src="../images/suites/suite0.jpg" alt="Executive Suite">

                        <div class="room-content">
                            <h3>Executive Suite</h3>

                            <p class="capacity">
                                👤 4 Guests
                            </p>

                            <p>
                                Premium suite with lounge access and luxury amenities.
                            </p>

                            <button
                                class="room-btn"
                                type="button"
                                onclick="showRates('Executive Suite')">
                                Select Room
                            </button>
                        </div>
                    </div>

                </div>

            </div>


                <!-- STEP 3 -->
            <div id="ratesSection" style="display:none;">

                <h2>Select Rate</h2>

                <div class="rate-card">

                    <div class="rate-option">
                        <label>
                            <span>
                                <input type="radio"
                                    name="rate"
                                    value="room_only"
                                    checked>
                                Room Only
                            </span>

                            <strong id="roomOnlyPrice">
                                ₱3,500/night
                            </strong>
                        </label>
                    </div>

                    <div class="rate-option">
                        <label>
                            <span>
                                <input type="radio"
                                    name="rate"
                                    value="breakfast">
                                Breakfast Included
                            </span>

                            <strong id="breakfastPrice">
                                ₱4,200/night
                            </strong>
                        </label>
                    </div>

                </div>

                <div class="addon-section">

                    <h3>Additional Services</h3>

                    <div class="service-row">
                        <span>Pet Accommodation</span>
                        <span>₱500</span>
                        <button type="button"
                                onclick="addService(this,500,'Pet Accommodation')">
                            Add
                        </button>
                    </div>

                    <div class="service-row">
                        <span>Floral Arrangement</span>
                        <span>₱1,200</span>
                        <button type="button"
                                onclick="addService(this,1200,'Floral Arrangement')">
                            Add
                        </button>
                    </div>

                    <div class="service-row">
                        <span>Airport Transfer</span>
                        <span>₱800</span>
                        <button type="button"
                                onclick="addService(this,800,'Airport Transfer')">
                            Add
                        </button>
                    </div>

                    <div class="service-row">
                        <span>Extra Bed</span>
                        <span>₱1,000</span>
                        <button type="button"
                                onclick="addService(this,1000,'Extra Bed')">
                            Add
                        </button>
                    </div>

                </div>

                <button
                    class="continue-btn"
                    type="button"
                    onclick="showSummary()">
                    Continue
                </button>

            </div>


            <div id="summarySection" style="display:none;">

                <h2>Booking Summary</h2>

                <div class="rate-card">

                    <h3>Reservation Details</h3>

                    <p>
                        <strong>Dates:</strong>
                        <span id="summaryDates"></span>
                    </p>

                    <p>
                        <strong>Guests:</strong>
                        <span id="summaryGuests"></span>
                    </p>

                    <p>
                        <strong>Room:</strong>
                        <span id="summaryRoom"></span>
                    </p>

                    <p>
                        <strong>Rate:</strong>
                        <span id="summaryRate"></span>
                    </p>

                </div>

                <div class="rate-card">

                    <h3>Selected Services</h3>

                    <div id="summaryServices">
                        None Selected
                    </div>

                </div>

                <div class="rate-card">

                    <h3>Price Breakdown</h3>

                    <p>
                        Room Rate:
                        <strong id="summaryRoomRate"></strong>
                    </p>

                    <p>
                        Add-ons:
                        <strong id="summaryAddonRate"></strong>
                    </p>

                    <hr>

                    <p>
                        Total:
                        <strong id="summaryTotal"></strong>
                    </p>

                </div>

                <button
                    class="continue-btn"
                    type="button"
                    onclick="showPayment()">
                    Proceed to Payment
                </button>

            </div>


            <!-- STEP 5 -->
            <div id="paymentSection" style="display:none;">

                <h2>Payment Details</h2>

                <div class="rate-card">

                    <h3>Guest Information</h3>

                    <p>
                        <strong>Name:</strong>
                        <span id="guestName">
                            Juan Dela Cruz
                        </span>
                    </p>

                    <p>
                        <strong>Email:</strong>
                        <span id="guestEmail">
                            juan@email.com
                        </span>
                    </p>

                    <p>
                        <strong>Phone:</strong>
                        <span id="guestPhone">
                            09123456789
                        </span>
                    </p>

                </div>

                <div class="rate-card">

                    <h3>Payment Method</h3>

                    <label>
                        <input
                            type="radio"
                            name="paymentMethod"
                            value="gcash"
                            checked
                            onchange="updatePaymentInfo()">
                        GCash
                    </label>

                    <br>

                    <label>
                        <input
                            type="radio"
                            name="paymentMethod"
                            value="bank"
                            onchange="updatePaymentInfo()">
                        Bank Transfer
                    </label>

                    <br>

                    <label>
                        <input
                            type="radio"
                            name="paymentMethod"
                            value="cash"
                            onchange="updatePaymentInfo()">
                        Cash on Arrival
                    </label>

                </div>

                <div class="rate-card">

                    <h3>Payment Instructions</h3>

                    <div id="paymentInfo">

                        <p>
                            <strong>GCash Number:</strong>
                            09123456789
                        </p>

                        <p>
                            <strong>Account Name:</strong>
                            ABC Hotel
                        </p>

                    </div>

                </div>

                <div class="rate-card">

                    <h3>Upload Receipt</h3>

                    <input
                        type="file"
                        id="receipt"
                        accept="image/*,.pdf">
                </div>

                <button
                    class="continue-btn"
                    type="button">
                    Confirm Reservation
                </button>

            </div>

    </div>
        

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>

function updateBreadcrumb(step){

    const crumbs = [
        "crumbDates",
        "crumbCategories",
        "crumbRates",
        "crumbSummary",
        "crumbDetails"
    ];

    crumbs.forEach((id,index)=>{

        const crumb =
            document.getElementById(id);

        crumb.classList.remove(
            "active",
            "completed"
        );

        if(index < step){

            crumb.classList.add(
                "completed"
            );

        }else if(index === step){

            crumb.classList.add(
                "active"
            );
        }

    });
}

function goToStep(step){

    document.getElementById("bookingSection").style.display = "none";
    document.getElementById("roomSection").style.display = "none";
    document.getElementById("ratesSection").style.display = "none";
    document.getElementById("summarySection").style.display = "none";
    document.getElementById("paymentSection").style.display = "none";

    if(step === 0){

    document.getElementById("datesContainer")
        .style.display = "block";

    document.getElementById("mainContainer")
        .style.display = "none";

    document.getElementById("bookingSection")
        .style.display = "block";
    }
    
    if(step === 1){

    document.getElementById("datesContainer")
        .style.display = "none";

    document.getElementById("mainContainer")
        .style.display = "block";

    document.getElementById("roomSection")
        .style.display = "block";
    }

    if(step === 2){

    document.getElementById("datesContainer")
        .style.display = "none";

    document.getElementById("mainContainer")
        .style.display = "block";

    document.getElementById("ratesSection")
        .style.display = "block";
    }

    if(step === 3){

    document.getElementById("datesContainer")
        .style.display = "none";

    document.getElementById("mainContainer")
        .style.display = "block";

    document.getElementById("summarySection")
        .style.display = "block";
    }

    if(step === 4){

    document.getElementById("datesContainer")
        .style.display = "none";

    document.getElementById("mainContainer")
        .style.display = "block";

    document.getElementById("paymentSection")
        .style.display = "block";
    }

    updateBreadcrumb(step);
}

flatpickr("#dateRange", {
    mode: "range",
    minDate: "today",
    dateFormat: "M d, Y"
});



function showRooms(){

    const dates =
        document.getElementById("dateRange").value;

    if(dates === ""){
        alert("Please select your dates first.");
        return;
    }

    document.getElementById("datesContainer")
        .style.display = "none";

    document.getElementById("mainContainer")
        .style.display = "block";

    document.getElementById("roomSection")
        .style.display = "block";

    updateBreadcrumb(1);
}

function goBack(){
    document.getElementById("roomSection").style.display = "none";
    document.getElementById("bookingSection").style.display = "block";
}

let selectedRoom = "";


function showRates(room){

    selectedRoom = room;

    document.getElementById("roomSection").style.display = "none";
    document.getElementById("ratesSection").style.display = "block";

    updateBreadcrumb(2);
}

let roomOnlyBase = 3500;
let breakfastBase = 4200;

let addonTotal = 0;

let selectedServices = [];



function updatePrices(){

    document.getElementById("roomOnlyPrice").innerText =
        "₱" + (roomOnlyBase + addonTotal).toLocaleString() + "/night";

    document.getElementById("breakfastPrice").innerText =
        "₱" + (breakfastBase + addonTotal).toLocaleString() + "/night";
}

function addService(button, price, serviceName){

    if(button.dataset.added === "true"){

        addonTotal -= price;

        selectedServices =
            selectedServices.filter(
                item => item !== serviceName
            );

        button.innerText = "Add";
        button.style.background = "#28a745";
        button.dataset.added = "false";

    }else{

        addonTotal += price;

        selectedServices.push(serviceName);

        button.innerText = "Remove";
        button.style.background = "#dc3545";
        button.dataset.added = "true";

    }

    updatePrices();
}


function showSummary(){

    document.getElementById("ratesSection").style.display = "none";
    document.getElementById("summarySection").style.display = "block";

    document.getElementById("summaryDates").innerText =
        document.getElementById("dateRange").value;

    let adults =
        document.getElementById("adults").value;

    let children =
        document.getElementById("children").value;

    document.getElementById("summaryGuests").innerText =
        adults + " Adults, " +
        children + " Children";

    document.getElementById("summaryRoom").innerText =
        selectedRoom;

    let selectedRate =
        document.querySelector(
            'input[name="rate"]:checked'
        ).value;

    if(selectedRate === "room_only"){

        document.getElementById("summaryRate").innerText =
            "Room Only";

        document.getElementById("summaryRoomRate").innerText =
            "₱" + roomOnlyBase.toLocaleString();

    }else{

        document.getElementById("summaryRate").innerText =
            "Breakfast Included";

        document.getElementById("summaryRoomRate").innerText =
            "₱" + breakfastBase.toLocaleString();
    }

    document.getElementById("summaryAddonRate").innerText =
        "₱" + addonTotal.toLocaleString();

    let total =
        selectedRate === "room_only"
        ? roomOnlyBase + addonTotal
        : breakfastBase + addonTotal;

    document.getElementById("summaryTotal").innerText =
        "₱" + total.toLocaleString();

    document.getElementById("summaryServices").innerHTML =
        selectedServices.length
        ? selectedServices.join("<br>")
        : "None Selected";

    updateBreadcrumb(3);
}

function showPayment(){

    document.getElementById("summarySection").style.display = "none";

    document.getElementById("paymentSection").style.display = "block";

    updateBreadcrumb(4);
}

function updatePaymentInfo(){

    let method =
        document.querySelector(
            'input[name="paymentMethod"]:checked'
        ).value;

    let paymentInfo =
        document.getElementById("paymentInfo");

    if(method === "gcash"){

        paymentInfo.innerHTML = `
            <p><strong>GCash Number:</strong> 09123456789</p>
            <p><strong>Account Name:</strong> ABC Hotel</p>
        `;

    }else if(method === "bank"){

        paymentInfo.innerHTML = `
            <p><strong>Bank:</strong> BDO</p>
            <p><strong>Account Name:</strong> ABC Hotel</p>
            <p><strong>Account Number:</strong> 1234567890</p>
        `;

    }else{

        paymentInfo.innerHTML = `
            <p>
                Payment will be collected upon arrival.
            </p>
        `;
    }
}

</script>

</body>
</html>