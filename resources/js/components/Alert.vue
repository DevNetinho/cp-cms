<template>
    <div :class="estilo" role="alert">
        {{mensagem}}
    </div>

</template>

<script>

export default {
    props: ['tipo', 'mensagem'],
    computed: {
        estilo() {
            return 'alert alert-'+this.tipo
        }
    }
 
}
</script>
