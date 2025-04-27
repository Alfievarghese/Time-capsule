<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = htmlspecialchars($_POST['message']);
    $delivery_date = $_POST['delivery_date'];
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    if (strtotime($delivery_date) <= strtotime('today')) {
        die("Please select a future date!");
    }

    $entry = [
        'email' => $email,
        'delivery_date' => $delivery_date,
        'message' => $message
    ];

    $all_entries = [];
    if (file_exists('messages.json')) {
        $all_entries = json_decode(file_get_contents('messages.json'), true);
    }
    $all_entries[] = $entry;

    file_put_contents('messages.json', json_encode($all_entries, JSON_PRETTY_PRINT));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Message Saved!</title>
  <style>
    body {
      background: #e0ffe0;
      font-family: 'Poppins', sans-serif;
      text-align: center;
      padding-top: 100px;
    }
    .checkmark {
      font-size: 80px;
      color: #4CAF50;
      animation: pop 0.6s ease forwards;
    }
    @keyframes pop {
      0% { transform: scale(0); opacity: 0; }
      100% { transform: scale(1); opacity: 1; }
    }
    h2 {
      color: #333;
      margin-top: 20px;
    }
  </style>
</head>
<body>

<div class="checkmark">✔️</div>
<h2>Thank you!<br>Your letter is saved for the future.</h2>

</body>
</html>