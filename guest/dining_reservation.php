<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Dining Reservation</title>

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<style>

body{
    margin:0;
    font-family:Arial,sans-serif;
    background:#f4f4f4;
}

.container{
    max-width:800px;
    margin:40px auto;
    background:white;
    padding:30px;
    border-radius:15px;
    box-shadow:0 5px 20px rgba(0,0,0,.1);
}

.logo{
    text-align:center;
    font-size:28px;
    font-weight:bold;
    color:#c9a86a;
    margin-bottom:10px;
}

h2{
    text-align:center;
    margin-bottom:30px;
}

.field{
    margin-bottom:20px;
}

label{
    display:block;
    margin-bottom:8px;
    font-weight:bold;
}

input,
select,
textarea{
    width:100%;
    padding:12px;
    border:1px solid #ccc;
    border-radius:8px;
    box-sizing:border-box;
}

textarea{
    resize:none;
    height:100px;
}

.btn{
    width:100%;
    padding:14px;
    border:none;
    border-radius:8px;
    background:#c9a86a;
    color:white;
    font-size:16px;
    cursor:pointer;
}

.btn:hover{
    opacity:.9;
}

.summary-card{
    background:#fafafa;
    border:1px solid #ddd;
    border-radius:10px;
    padding:20px;
    margin-top:25px;
}

.summary-card h3{
    margin-top:0;
}

</style>

</head>
<body>

<div class="container">

    <div class="logo">
        ABC HOTEL RESTAURANT
    </div>

    <h2>Dining Reservation</h2>

    <form>

        <div class="field">
            <label>Date</label>

            <input
                type="text"
                id="reservationDate"
                placeholder="Select Date"
                required>
        </div>

        <div class="field">
            <label>Time</label>

            <select id="time">
                <option>11:00 AM</option>
                <option>12:00 PM</option>
                <option>1:00 PM</option>
                <option>2:00 PM</option>
                <option>6:00 PM</option>
                <option>7:00 PM</option>
                <option>8:00 PM</option>
            </select>
        </div>

        <div class="field">
            <label>Number of Guests</label>

            <input
                type="number"
                id="guests"
                min="1"
                value="2">
        </div>

        <div class="field">
            <label>Dining Area</label>

            <select id="area">
                <option>Main Dining Hall</option>
                <option>Garden Terrace</option>
                <option>Poolside Dining</option>
                <option>Private Dining Room</option>
            </select>
        </div>

        <div class="field">
            <label>Special Requests</label>

            <textarea
                id="requests"
                placeholder="Birthday setup, high chair, allergies, etc."></textarea>
        </div>

        <div class="summary-card">

            <h3>Guest Information</h3>

            <p>
                <strong>Name:</strong>
                Juan Dela Cruz
            </p>

            <p>
                <strong>Email:</strong>
                juan@email.com
            </p>

            <p>
                <strong>Phone:</strong>
                09123456789
            </p>

        </div>

        <button
            type="button"
            class="btn"
            onclick="showSummary()">

            Review Reservation

        </button>

    </form>

    <div
        id="summary"
        class="summary-card"
        style="display:none;">

        <h3>Reservation Summary</h3>

        <p><strong>Date:</strong> <span id="sDate"></span></p>

        <p><strong>Time:</strong> <span id="sTime"></span></p>

        <p><strong>Guests:</strong> <span id="sGuests"></span></p>

        <p><strong>Dining Area:</strong> <span id="sArea"></span></p>

        <p><strong>Requests:</strong> <span id="sRequests"></span></p>

        <button class="btn">
            Confirm Reservation
        </button>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>

flatpickr("#reservationDate",{
    minDate:"today",
    dateFormat:"F j, Y"
});

function showSummary(){

    document.getElementById("summary").style.display =
        "block";

    document.getElementById("sDate").innerText =
        document.getElementById("reservationDate").value;

    document.getElementById("sTime").innerText =
        document.getElementById("time").value;

    document.getElementById("sGuests").innerText =
        document.getElementById("guests").value;

    document.getElementById("sArea").innerText =
        document.getElementById("area").value;

    document.getElementById("sRequests").innerText =
        document.getElementById("requests").value || "None";
}

</script>

</body>
</html>