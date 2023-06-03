<!DOCTYPE html>
<html>

<head>
    <title>Coming Soon</title>
    <style>
    body {
        background-color: #f8f8f8;
        font-family: Arial, sans-serif;
        text-align: center;
        padding: 50px;
    }

    h1 {
        font-size: 36px;
        margin-bottom: 20px;
    }

    p {
        font-size: 18px;
        margin-bottom: 40px;
    }

    .countdown {
        font-size: 24px;
        margin-bottom: 40px;
    }

    .countdown span {
        margin: 0 5px;
    }

    .social-icons {
        list-style: none;
        padding: 0;
        margin-top: 40px;
    }

    .social-icons li {
        display: inline-block;
        margin: 0 10px;
    }

    .social-icons a {
        display: inline-block;
        color: #555;
        font-size: 24px;
        text-decoration: none;
        transition: color 0.3s;
    }

    .social-icons a:hover {
        color: #007bff;
    }
    </style>
</head>

<body>
    <h1>Coming Soon</h1>
    <p>We are working on something awesome. Stay tuned!</p>
    <div class="countdown">
        <span id="days">00</span> days
        <span id="hours">00</span> hours
        <span id="minutes">00</span> minutes
        <span id="seconds">00</span> seconds
    </div>
    <ul class="social-icons">
        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
        <li><a href="#"><i class="fa fa-instagram"></i></a></li>
        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
    </ul>

    <script>
    // Set the date and time to count down to
    var countDownDate = new Date("2023-06-15T00:00:00").getTime();

    // Update the countdown every second
    var countdownInterval = setInterval(function() {
        // Get the current date and time
        var now = new Date().getTime();

        // Calculate the time remaining
        var timeRemaining = countDownDate - now;

        // Calculate days, hours, minutes, and seconds
        var days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
        var hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

        // Display the countdown
        document.getElementById("days").innerHTML = formatTime(days);
        document.getElementById("hours").innerHTML = formatTime(hours);
        document.getElementById("minutes").innerHTML = formatTime(minutes);
        document.getElementById("seconds").innerHTML = formatTime(seconds);

        // If the countdown is finished, clear the interval
        if (timeRemaining <= 0) {
            clearInterval(countdownInterval);
            document.getElementById("countdown").innerHTML = "Coming Soon!";
        }
    }, 1000);

    // Format the time with leading zeros
    function formatTime(time) {
        return time.toString().padStart(2, '0');
    }
    </script>
</body>

</html>