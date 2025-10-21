<template>
  <div class="unauthenticated-container">
    <h1 class="error-heading">{{ $t('Unauthorized') }}</h1>
    <p class="error-message">{{ $t('You do not have the necessary permissions to access this page') }}</p>
    <a href="/driver/index" class="back-link">{{ $t('Back to Home Page') }}</a>
  </div>
</template>

<script>
export default {
  //
};
</script>

<style scoped>
.unauthenticated-container {
  max-width: 400px;
  margin: 50px auto;
  text-align: center;
}

.error-heading {
  color: #d9534f;
  font-size: 24px;
  margin-bottom: 10px;
}

.error-message {
  color: #777;
  font-size: 16px;
  margin-bottom: 20px;
}

.back-link {
  display: inline-block;
  padding: 10px 15px;
  background-color: #5bc0de;
  color: #fff;
  text-decoration: none;
  border-radius: 5px;
  transition: background-color 0.3s;
}

.back-link:hover {
  background-color: #46b8da;
}
</style>
