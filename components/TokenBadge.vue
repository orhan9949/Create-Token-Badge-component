<template>
 <token-badge-item
     v-for="item in data"
     :key="item.id"
     :item="item"
     :showChange="showChange"
     :showPrice="showPrice"
 >
 </token-badge-item>
</template>


<script>
import TokenBadgeItem from "./TokenBadgeItem.vue";
import axios from 'axios';

export default {
  name: 'TokenBadge',
  components: {
    TokenBadgeItem
  },
  props: {
    tokenId: String,
    showChange: Boolean,
    showPrice: Boolean
  },
  data(){
    return {
      data: []
    }
  },
  mounted() {
    this.updateData();
  },
  methods: {
    updateData() {

      const url = '/wp-json/crypto/v1/coins/' + this.tokenId;

      axios
        .get(url)
        .then((response) => {
          this.data.push(response.data);
        })
        .catch((error) => {
          console.log(error);
        });

    },
  }
}


</script>