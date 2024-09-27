<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews & Enquiries - TravelQuest</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap');
        
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        header {
            background-color: #5096dd;
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

        .container {
            width: 85%;
            margin: 50px auto;
        }

        h2 {
            text-align: center;
            font-size: 28px;
            color: #2c3e50;
        }

        
        .review-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 40px;
        }

        .review-form h3 {
            margin-bottom: 15px;
            color: #34495e;
            font-size: 24px;
        }

        .review-form input[type="text"],
        .review-form textarea {
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            outline: none;
        }

        .review-form button {
            padding: 15px 30px;
            background-color: #2980b9;
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .review-form button:hover {
            background-color: #1f5f8b;
        }

        
        .review-list {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .review-item {
            border-bottom: 1px solid #ddd;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .review-item:last-child {
            border-bottom: none;
        }

        .review-item h4 {
            color: #34495e;
            font-size: 20px;
            margin: 0;
        }

        .review-item p {
            color: #7f8c8d;
            font-size: 16px;
            margin: 10px 0;
        }

        .review-item .rating {
            color: #e74c3c;
        }

        
        .enquiry-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 40px;
        }

        .enquiry-form h3 {
            margin-bottom: 15px;
            color: #34495e;
            font-size: 24px;
        }

        .enquiry-form input[type="text"],
        .enquiry-form textarea {
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            outline: none;
        }

        .enquiry-form button {
            padding: 15px 30px;
            background-color: #27ae60;
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .enquiry-form button:hover {
            background-color: #229954;
        }

        
        footer {
            text-align: center;
            padding: 20px;
            background-color: #5096dd;
            color: white;
            font-size: 16px;
            box-shadow: 0 -4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
    </style>
</head>
<body>

    <header>
        <h1>TravelQuest</h1>
        <nav>
            <ul>
                <li><a href="./user_dashboard.php">Home</a></li>
                <li><a href="">Accommodations</a></li>
                <li><a href="#tours">Tours</a></li>
                <li><a href="./transport.php">Transport</a></li>
                <li><a href="./book_status.php">Bookings</a></li>
                <li><a href="./review&enquiry.php">Reviews</a></li>
  
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2>Customer Reviews</h2>

        
        <div class="review-form">
            <h3>Submit Your Review</h3>
            <form id="reviewForm">
                <input type="text" id="name" placeholder="Your Name" required>
                <textarea id="reviewText" rows="4" placeholder="Write your review..." required></textarea>
                <button type="submit">Submit Review</button>
            </form>
        </div>

        
        <div class="review-list">
            <h3>Recent Reviews</h3>
            <div class="review-item">
                <h4>John Doe <span class="rating">★★★★★</span></h4>
                <p>Had an amazing experience! The tour was well-organized and the guides were friendly.</p>
            </div>
            <div class="review-item">
                <h4>Jane Smith <span class="rating">★★★★☆</span></h4>
                <p>The trip was wonderful, but the accommodation could have been better. Overall, a great service.</p>
            </div>
        </div>

        
        <h2>Enquiry Section</h2>
        <div class="enquiry-form">
            <h3>Submit Your Enquiry</h3>
            <form id="enquiryForm">
                <input type="text" id="enquiryName" placeholder="Your Name" required>
                <input type="text" id="enquiryEmail" placeholder="Your Email" required>
                <textarea id="enquiryMessage" rows="4" placeholder="Write your enquiry..." required></textarea>
                <button type="submit">Submit Enquiry</button>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Tourism Management System</p>
    </footer>

    <script>
        
        document.getElementById('reviewForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const name = document.getElementById('name').value;
            const reviewText = document.getElementById('reviewText').value;
            if (name && reviewText) {
                const reviewList = document.querySelector('.review-list');
                const newReview = document.createElement('div');
                newReview.classList.add('review-item');
                newReview.innerHTML = `<h4>${name} <span class="rating">★★★★★</span></h4><p>${reviewText}</p>`;
                reviewList.appendChild(newReview);
                document.getElementById('reviewForm').reset();
            } else {
                alert("Please fill out all fields.");
            }
        });

        
        document.getElementById('enquiryForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const enquiryName = document.getElementById('enquiryName').value;
            const enquiryEmail = document.getElementById('enquiryEmail').value;
            const enquiryMessage = document.getElementById('enquiryMessage').value;
            if (enquiryName && enquiryEmail && enquiryMessage) {
                alert(`Thank you ${enquiryName}! Your enquiry has been submitted.`);
                document.getElementById('enquiryForm').reset();
            } else {
                alert("Please fill out all fields.");
            }
        });
    </script>

</body>
</html>
