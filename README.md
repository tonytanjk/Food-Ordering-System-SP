# Food Ordering System @ SP

## Project Overview
The Food Ordering System is designed to streamline the process of ordering food for students and food stall owners at our school. This web-based application allows students to browse, order, and pay for food from various stalls, while providing stall owners with a platform to manage orders and track sales.

## Features

### Authentication and User Login
- **Student Sign-Up**: Students can sign up using their admission number and password.
- **Password Recovery**: If students forget their password, they can request a password reset email.
- **Secure Login**: Both students and stall owners can securely log in to their respective accounts.

### Admin Login
- **Stall Owner Access**: Stall owners can log in using a unique ID and password.
- **Order Management**: Stall owners can view student IDs and payment details for orders placed at their stalls.

### Student Features
- **Browse Food Courts**: Students can explore different food courts and view available stalls.
- **Order Food**: Students can select food items from various stalls and place orders.
- **Online Payment**: Students must pay online based on the price of the food they order.
- **Order History**: Students can view their past orders and order details.

### Stall Owner Features
- **Manage Orders**: Stall owners can view and manage incoming orders on the "Admin Page".
- **Sales Metrics**: Stall owners can track total sales, total orders, average order value, and sales trends.
- **Stall Items Management**: Stall owners can add, edit, and delete food items available at their stalls.

### Database Structure
The system uses a MySQL database with the following tables:

#### `users`
- `user_id`: Unique identifier for each user.
- `username`: Username of the user.
- `email`: Email address of the user.
- `password`: Password for user authentication.
- `phone`: Contact number of the user.
- `profile_picture`: Path to the user's profile picture.
- `account_balance`: Balance in the user's account.
- `roles`: Role of the user (e.g., student, vendor).
- `stall_id`: ID of the stall associated with the user (for stall owners).
- `food_court_id`: ID of the food court associated with the user (for stall owners).

#### `food_courts`
- `food_court_id`: Unique identifier for each food court.
- `name`: Name of the food court.
- `location`: Location of the food court.
- `contact_number`: Contact number for the food court.
- `image_path`: Path to the image of the food court.

#### `food_stalls`
- `stall_id`: Unique identifier for each food stall.
- `stall_name`: Name of the food stall.
- `food_court_id`: ID of the food court where the stall is located.
- `contact_number`: Contact number for the stall.
- `availability`: Availability status of the stall (Open, Closed, Temporarily Closed).
- `opening_time`: Opening time of the stall.
- `closing_time`: Closing time of the stall.
- `description`: Description of the stall.
- `stall_picture`: Path to the image of the stall.

#### `food_items`
- `food_item_id`: Unique identifier for each food item.
- `food_name`: Name of the food item.
- `description`: Description of the food item.
- `price`: Price of the food item.
- `category`: Category of the food item.
- `stall_id`: ID of the stall offering the food item.
- `image_path`: Path to the image of the food item.

#### `orders`
- `order_id`: Unique identifier for each order.
- `user_id`: ID of the user who placed the order.
- `total_amount`: Total amount of the order.
- `status`: Status of the order (Pending, Completed, Cancelled).
- `payment_method`: Payment method used for the order.
- `order_date`: Date and time when the order was placed.
- `tracking_id`: Unique tracking ID for the order.

#### `order_items`
- `order_item_id`: Unique identifier for each order item.
- `order_id`: ID of the order.
- `food_item_id`: ID of the food item.
- `quantity`: Quantity of the food item ordered.
- `price`: Price of the food item.

#### `most_ordered`
- `most_ordered_id`: Unique identifier for each most ordered record.
- `food_item_id`: ID of the food item.
- `food_court_id`: ID of the food court.
- `order_count`: Number of times the food item has been ordered.
- `last_updated`: Date and time when the record was last updated.

## Getting Started
To get started with the Food Ordering System, follow these steps:

1. **Clone the Repository**: Clone the project repository to your local machine.
2. **Set Up the Database**: Import the provided SQL dump file to set up the MySQL database.
3. **Configure the Application**: Update the database connection settings in `common.php`.
4. **Run the Application**: Start your web server and navigate to the application URL.