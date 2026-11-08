<?php
    include 'includes/header.php';
?>

<section class="contact">

    <div class="container">

        <h1>Contact Us</h1>

        <p class="contact-text">
            Have any questions or feedback? We'd love to hear from you.
            Please fill in the form below.
        </p>

        <form action="#" method="post">

            <label>Full Name</label>
            <input type="text" name="fullname" required>

            <label>Email Address</label>
            <input type="email" name="email" required>

            <label>Subject</label>
            <input type="text" name="subject" required>

            <label>Message</label>
            <textarea name="message" rows="6" required></textarea>

            <button type="submit" class="btn">Send Message</button>

        </form>

    </div>

</section>

<?php
    include 'includes/footer.php';
?>

