<?php
// Inclusion du fichier config.php
require_once "config.php"; ?>
<link rel="stylesheet" href="css/footer.css">
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <h4><?php echo SOCIAL_LINKS?></h4>
                <ul class="list-inline">
                    <li class="list-inline-item">
                        <a href="https://www.linkedin.com/company/thales/">
                            <i class="fab fa-linkedin fa-2x"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="https://twitter.com/thalesgroup">
                            <i class="fab fa-twitter fa-2x"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="https://www.facebook.com/thalesgroup">
                            <i class="fab fa-facebook fa-2x"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="https://www.youtube.com/user/thethalesgroup">
                            <i class="fab fa-youtube fa-2x"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="https://www.instagram.com/thalesgroup/">
                            <i class="fab fa-instagram fa-2x"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-sm-4">
                <h4><?php echo CONTACT_US?></h4>
                <ul class="list-unstyled">
                    <li class="phone"></li>
                </ul>
            </div>
            <div class="col-sm-4">
                <h4><?php echo INFOS?></h4>
                <ul class="list-unstyled">
                    <li>
                        <a href="#"><?php echo CONDITIONS?></a>
                    </li>
                    <li>
                        <a href="#"><?php echo CREDITS?></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="copyright">
        &copy; Copyright <?php echo date('Y'); ?>
    </div>
</footer>
