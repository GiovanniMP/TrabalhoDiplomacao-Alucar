<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>



<template>
    <div class="alert-box">
      <strong>Teste de alerta</strong>
      <slot />
    </div>
  </template>
  
  <style scoped>
  .alert-box {
    /* ... */
  }
  </style>
  

<script>
    export default {
        mounted() {
            console.log('Componente montado.')
        }
    }
</script>

