<?php include 'includes/navbar.php'; ?>
<h1>Contact Us</h1>
<form action="process/submit_enquiry.php" method="POST">
  <input type="text" name="name" placeholder="Your Name" required class="form-control my-2">
  <input type="email" name="email" placeholder="Your Email" required class="form-control my-2">
  <input type="text" name="destination" placeholder="Destination Name" required class="form-control my-2">
  <textarea name="message" placeholder="Your Message" required class="form-control my-2"></textarea>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
<?php include 'includes/footer.php'; ?>