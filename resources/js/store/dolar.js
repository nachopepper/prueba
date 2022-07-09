// stores/counter.js
import axios from 'axios'
import { defineStore } from 'pinia'

export const useDolarStore = defineStore('dolar', {
  state: () => {
    return { dolarPrice: [] }
  },
  // could also be defined as
  // state: () => ({ count: 0 })
  actions: {
    async getDolarPrice() {
        const response = await axios.get('api/getDolar');
        this.dolarPrice = response;
        console.log('dolar', response)
    },
  },
 
})