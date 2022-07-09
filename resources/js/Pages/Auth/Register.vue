<script setup>
import { ref } from "vue";
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue';
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetCheckbox from '@/Jetstream/Checkbox.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';
import { useDolarStore } from '../../store/dolar';
import { onMounted } from '@vue/runtime-core';
import axios from 'axios';

const dolarPrice = ref([]);
const selected = ref(null);

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const search = async () => {
    console.log(selected.value);
    const data = {
        month: selected.value
    }
    const response = await axios.get('api/getDolar', data);
    dolarPrice.value = response.data.response.Dolares.filter((el) => (el.Fecha[5] + el.Fecha[6]) === selected.value);
}

const downloadExcel = async () => {
    console.log(selected.value);
    const data = {
        month: selected.value
    }
    const response = await axios.get('api/downloadExcel', data);

    const url = URL.createObjectURL(new Blob([response.data], {
        type: 'application/vnd.ms-excel'
    }))
    const link = document.createElement('a')
    link.href = url
    link.setAttribute('download', 'myfile')
    document.body.appendChild(link)
    link.click()
}




</script>

<template>

    <Head title="Register" />

    <JetAuthenticationCard>


        <div>
            Valor dolar
            <select v-model="selected">
                <option disabled value="">Seleccione un mes</option>
                <option value="01">Enero</option>
                <option value="02">Febrero</option>
                <option value="03">Marzo</option>
                <option value="04">Abril</option>
                <option value="05">Mayo</option>
                <option value="06">Junio</option>
                <option value="07">Julio</option>
                <option value="08">Agosto</option>
                <option value="09">Septiembre</option>
                <option value="10">Octubre</option>
                <option value="11">Noviembre</option>
                <option value="12">Diciembre</option>
            </select>
            <button v-if="selected" type="button" @click="search">Buscar</button>
            <button v-if="selected" type="button" @click="downloadExcel">Descargar Excel</button>
        </div>

        <div class="mt-4" v-for="(price, i) in dolarPrice" :key="i">
            Valor: {{ price.Valor }}
            Fecha: {{ price.Fecha }}
        </div>


    </JetAuthenticationCard>
</template>
