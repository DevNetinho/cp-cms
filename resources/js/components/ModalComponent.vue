<template>
   

    <!-- Modal -->
    <div class="modal fade" id="modalEditarRemover" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <!-- CABEÇALHO DO MODEL -->
        <div class="modal-header">
            <h5 class="modal-title" id="ModalLabel"> {{titulo}} </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <!-- BODY DO MODEL -->
        <div class="modal-body">

            <slot name="conteudo"></slot>

        </div>

        <!-- FOOTER DO MODEL -->
        <div class="modal-footer">
            <slot name="footer"></slot>
            
        </div>
        </div>
    </div>
    </div>


</template>

<script>
    export default {
        props: ['titulo']

    }
</script>
