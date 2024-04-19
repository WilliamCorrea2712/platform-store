<template>
    <div class="address border rounded p-3 mb-3">
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="nameAddress">{{ __("Nome") }}:</label>
                <input
                    type="text"
                    class="form-control"
                    v-model="address.nameAddress"
                    required
                />
            </div>
            <div class="form-group col-md-5">
                <label for="street">{{ __("Rua") }}:</label>
                <input
                    type="text"
                    class="form-control"
                    v-model="address.street"
                    required
                />
            </div>
            <div class="form-group col-md-3">
                <label for="number">{{ __("Número") }}:</label>
                <input
                    type="text"
                    class="form-control"
                    v-model="address.number"
                    required
                />
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="city">{{ __("Cidade") }}:</label>
                <input
                    type="text"
                    class="form-control"
                    v-model="address.city"
                    required
                />
            </div>
            <div class="form-group col-md-3">
                <label for="state">{{ __("Estado") }}:</label>
                <input
                    type="text"
                    class="form-control"
                    v-model="address.state"
                    required
                />
            </div>
            <div class="form-group col-md-3">
                <label for="zip_code">{{ __("CEP") }}:</label>
                <input
                    type="text"
                    class="form-control"
                    v-model="address.zip_code"
                    required
                />
            </div>
            <div class="form-group col-md-3">
                <label for="country">{{ __("País") }}:</label>
                <input
                    type="text"
                    class="form-control"
                    v-model="address.country"
                    required
                />
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            address: {
                nameAddress: "",
                street: "",
                number: "",
                city: "",
                state: "",
                zip_code: "",
                country: "",
            },
        };
    },
};
</script>

<style>
/* Estilos do componente */
</style>
