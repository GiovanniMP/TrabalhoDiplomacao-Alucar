<template>
    <div class="card" style="width: 18rem;">
        <slot name="imagem"></slot>
        <div class="card-body">
            <h5 class="card-title">{{ titulo}} </h5>
            <slot name="botao"></slot>
        </div>
    </div>
</template>

<script>
    export default{
        props: ['titulo']
    }
</script>