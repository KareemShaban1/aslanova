<template>
    <footer class="footer-section">
        <div class="containerFooter">
            <div class="mb-4 footer-logo-wrap">
                <a href="#" class="footer-logo">Aslanova</a>
            </div>
            <div class="row g-5 mb-5">

                <div class="col-lg-8">
                    <div class="row links-wrap">
                        <div class="col-12 col-lg-4">
                            <ul class="list-unstyled">
                                <li><router-link to="/dashboard/agb">{{ $t('AGB') }}</router-link></li>
                                <li><router-link to="/dashboard/datenschutzerklarung">{{ $t('Datenschutzerklarung')
                                        }}</router-link></li>
                                <li><router-link to="/dashboard/impressum">{{ $t('Impressum') }}</router-link></li>
                                <li><router-link to="/dashboard/kunden_info">{{ $t('Kunden info') }}</router-link></li>
                            </ul>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="contact-info">
                                <p>{{ $t('Email') }}: <a
                                        href="mailto:Mobelaslan.kontakt@gmail.com">Mobelaslan.kontakt@gmail.com</a></p>
                                <p>{{ $t("Phone") }}: 0176 63037645</p>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <ul class="list-unstyled custom-socialMidea ">
                                <li><a href="https://www.facebook.com/profile.php?id=100069791187026" target="_blank"
                                        aria-label="Facebook" class="fa fa-brands fa-facebook-f"></a></li>
                                <li><a href="https://www.instagram.com/mobel_aslan?igsh=bnMya3Ixd2JkbXN5"
                                        target="_blank" aria-label="Instagram" class="fa fa-brands fa-instagram"></a>
                                </li>
                                <li><a href="http://wa.me/4917663037645" target="_blank" aria-label="WhatsApp"
                                        class="fa fa-brands fa-whatsapp"></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>

<script setup>
// Add any JavaScript logic if necessary
</script>

<style scoped>
.footer-section {
    padding: 2rem 0;
    background-color: #f8f9fa;
}

.subscription-form h3 {
    display: flex;
    align-items: center;
}

.subscription-form input {
    margin-right: 0.5rem;
}

.custom-socialMidea {
    width: 400px;
    display: flex;
    flex-direction: row;
    width: 100%;
    gap: 5px;

}

.containerFooter {
    margin: 0px 10px !important;
    width: 100% !important;
    padding: 20px !important;
}

.custom-socialMidea span {
    font-size: 1.5rem;
    color: var(--mainColor);
    margin-right: 10px;
}

.footer-logo {
    font-size: 2rem;
    color: #333;
}

.footer-logo span {
    color: var(--mainColor);
    text-align: center;
}

.border-top {
    border-top: 1px solid #dee2e6;
}



.custom-socialMidea li a:hover {
    color: var(--mainColor);
    background-color: white;
}

.custom-socialMidea li a {
    display: flex;
    justify-content: center !important;
    align-items: center !important;
    background-color: var(--mainColor);
    border: 1px var(--mainColor) solid;
    color: white;
    width: 40px;
    height: 40px;
    border-radius: 50%;
}

.contact-info p {
    margin: 0.5rem 0;
}
</style>
