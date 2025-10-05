<template>
  <span class="token-badge" :id=" item.id " :data-title="item.name ">
    <img class="token-badge__image" :src=" item.image " :alt=" item.name ">
    <span class="token-badge__symbol">{{ item.symbol }}</span>
    <span class="token-badge__price"
          v-if="showPrice"
    >{{ price }}</span>
    <span class="token-badge__change"
          v-if="showChange"
          :class="this.changeUp === true ? 'token-badge__change-color--up' : 'token-badge__change-color--down'"
    >{{ percent }}</span>
    <a class="token-badge__link" :href=" item.link ">{{ item.name }}</a>
  </span>
</template>

<script>
import { formatPrice, formatPercentage } from '../helpers/format';

export default {
  name: 'TokenBadgeItem',
  props: {
    item: Object,
    showChange: Boolean,
    showPrice: Boolean
  },
  data(){
    return {
      changeUp: false,
      price: formatPrice(this.item.current_price, 2),
      percent: formatPercentage(this.item.price_change_percentage_24h)
    }
  },
  mounted() {
    this.changeUpMethod();
  },
  methods: {
    changeUpMethod(){
      if(Number(this.item.price_change_percentage_24h) > 0){
          this.changeUp = true;
      }
    }
  }
};
</script>