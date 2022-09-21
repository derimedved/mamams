<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>


  <?php

      if (!is_user_logged_in())
          if (!$_GET['excl'])
            if (get_the_id() !== 274 && get_the_id() !== 3185 && get_the_id() !== 619) {?>

          <script>
            location.href = "<?= get_permalink(3185) ?>"
          </script>
  <?php
          }

  ?>
  @php
    wp_head();

    if (is_archive('lp_course')) {
        $layer['pageType'] = 'all-courses';
    }



    if (is_singular('lp_course') )
      $layer['pageType'] = 'course';

    if (get_the_id() ==  2329) {
      $layer['pageType'] = 'checkout';
      $layer['checkoutType'] = 'multi';
      $layer['checkoutStepNumber'] = '1';
      $layer['checkoutStepName'] = 'option';

    }

    if (get_the_id() ==  519) {
      $layer['pageType'] = 'checkout';
      $layer['checkoutType'] = 'abonnement';
      $layer['checkoutStepNumber'] = '1';
      $layer['checkoutStepName'] = 'option';
    }

    if(basename(get_page_template()) == "template-levenement.blade.php" ||
      basename(get_page_template()) == "template-landing.blade.php" ||
      basename(get_page_template()) == "template-bonheur.blade.php" ||
      basename(get_page_template()) == "template-bonheur-reg.blade.php"){
      $layer['pageType'] = 'landing';

    }

  



  @endphp





  <script>
    dataLayer.push(<?= json_encode($layer) ?>);
  </script>


</head>
