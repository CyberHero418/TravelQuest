<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transport Booking</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap');
        
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 100vh;
        }

        
        header {
            background-color: #356698;
            padding: 20px 0;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            color: #fff;
            font-size: 36px;
            letter-spacing: 2px;
            margin: 0;
        }

        header nav ul {
            list-style: none;
            padding: 0;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        header nav ul li a {
            color: #fff;
            text-decoration: none;
            padding: 10px 15px;
            background-color: #1abc9c;
            border-radius: 50px;
            transition: background-color 0.3s;
            font-weight: 600;
        }

        header nav ul li a:hover {
            background-color: #16a085;
        }

        
        .booking-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 500px;
            margin: 40px auto;
            text-align: center;
        }

        .booking-container h1 {
            margin-bottom: 20px;
            color: #1abc9c;
            font-size: 28px;
        }

        .booking-container form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .booking-container select, 
        .booking-container input[type="text"], 
        .booking-container input[type="date"], 
        .booking-container input[type="number"] {
            width: calc(100% - 20px);
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s ease;
        }

        .booking-container input:hover,
        .booking-container select:hover,
        .booking-container input:focus,
        .booking-container select:focus {
            border-color: #1abc9c;
            outline: none;
        }

        .booking-container button {
            width: 100%;
            padding: 12px;
            background-color: #1abc9c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
            transition: background-color 0.3s;
        }

        .booking-container button:hover {
            background-color: #16a085;
        }

        
        footer {
            text-align: center;
            padding: 20px;
            background-color: #57a3ba;
            color: white;
            font-size: 16px;
            box-shadow: 0 -4px 6px rgba(0, 0, 0, 0.1);
        }

    </style>
</head>
<body>

    
    <header>
        <h1>TravelQuest</h1>
        <nav>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#accommodations">Accommodations</a></li>
                <li><a href="#tours">Tours</a></li>
                <li><a href="#transport">Transport</a></li>
                <li><a href="#bookings">Bookings</a></li>
                <li><a href="#reviews&Enquiry">Reviews and Enquiry</a></li>
                <li><a href="#payments">Payments</a></li>
                <li><a href="#admin">Admin</a></li>
            </ul>
        </nav>
    </header>

  
    <div class="booking-container">
        <h1>Book Your Transport</h1>
        <form action="#" method="POST">
            
            <select name="transport-type" required>
                <option value="">Select Transport Type</option>
                <option value="bus">Bus</option>
                <option value="train">Train</option>
                <option value="air">Air</option>
            </select>

            
            <input type="text" name="departure" placeholder="Departure Location" required>

            
            <input type="text" name="destination" placeholder="Destination Location" required>

            
            <input type="date" name="date" placeholder="Travel Date" required>

            
            <input type="number" name="passengers" placeholder="Number of Passengers" min="1" max="10" required>

            
            <button type="submit">Book Now</button>
        </form>
    </div>

    
    <footer>
        <p>&copy; 2024 Tourism Management System</p>
    </footer>

</body>
</html>
