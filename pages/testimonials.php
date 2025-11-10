<?php include 'header.php'; ?>

<!-- Main Content -->
<main id="main">

  <!-- Testimonials Section -->
  <section id="testimonials" class="testimonials section">
    <div class="container section-title" data-aos="fade-up">
      <h2>Testimonials</h2>
      <p>Ce que les visiteurs disent de mon portfolio.</p>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="swiper swiper-testimonials">
        <div class="swiper-wrapper">
          <?php
          include('db.php'); // Connexion à la base de données
          $sql = "SELECT * FROM testimonials ORDER BY created_at DESC";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  echo '<div class="swiper-slide">';
                  echo '<div class="testimonial-item">';
                  echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
                  echo '<h4>' . htmlspecialchars($row['title']) . '</h4>';
                  echo '<div class="stars">';
                  for ($i = 0; $i < $row['rating']; $i++) {
                      echo '<i class="bi bi-star-fill"></i>';
                  }
                  echo '</div>';
                  echo '<p><i class="bi bi-quote quote-icon-left"></i>';
                  echo htmlspecialchars($row['message']);
                  echo '<i class="bi bi-quote quote-icon-right"></i></p>';

                  // Bouton de suppression
                  echo '<form action="delete_testimonial.php" method="POST" style="margin-top: 10px;">';
                  echo '<input type="hidden" name="id" value="' . htmlspecialchars($row['id']) . '">';
                  echo '<button type="submit" class="btn btn-danger btn-sm">Supprimer</button>';
                  echo '</form>';

                  echo '</div>';
                  echo '</div>';
              }
          } else {
              echo '<p>Aucun avis pour le moment.</p>';
          }
          ?>
        </div>
        <div class="swiper-pagination"></div>
      </div>
    </div>
  </section>

  <!-- Leave Testimonial Section -->
  <section id="leave-testimonial" class="section">
    <div class="container">
      <h2>Laissez un avis</h2>
      <form action="submit_testimonial.php" method="POST">
        <div class="mb-3">
          <label for="name" class="form-label">Nom</label>
          <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="title" class="form-label">Titre (optionnel)</label>
          <input type="text" name="title" id="title" class="form-control">
        </div>
        <div class="mb-3">
          <label for="message" class="form-label">Message</label>
          <textarea name="message" id="message" class="form-control" rows="4" required></textarea>
        </div>
        <div class="mb-3">
          <label for="rating" class="form-label">Note</label>
          <select name="rating" id="rating" class="form-select" required>
            <option value="5">5 étoiles</option>
            <option value="4">4 étoiles</option>
            <option value="3">3 étoiles</option>
            <option value="2">2 étoiles</option>
            <option value="1">1 étoile</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
      </form>
    </div>
  </section>

</main>

<?php include 'footer.php'; ?>

<!-- Scripts -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/js/main.js"></script>

<script>
  // Confirmation avant suppression
  document.querySelectorAll('form[action="delete_testimonial.php"]').forEach(form => {
    form.addEventListener('submit', function (e) {
      if (!confirm('Êtes-vous sûr de vouloir supprimer cet avis ?')) {
        e.preventDefault();
      }
    });
  });
</script>

</body>
</html>
