<template>
  <div class="form-group">
    <h2>Product list</h2>

    <div class="card card-body" v-for="item in products" v-bind:key="item.id">
      <img
        src="https://picsum.photos/600/300/?image=25"
        alt="Girl in a jacket"
        width="150"
        height="200"
      />
      <span
        ><strong>{{ item.name }} DH</strong></span
      >
      {{item.description}}
      <span
        ><strong>{{ item.price }} DH</strong></span
      >
      <button class="btn btn-warning">Delete</button>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data: function () {
    return {
      products: [],
      categories: [],
    };
  },
  created() {
    this.loadProducts();
    this.loadCategories();
  },
  methods: { 
    loadCategories: function () {
      axios
        .get("/api/getcategories")
        .then((response) => {
          this.categories = response.data;
          console.log(this.categories);
        })
        .catch(function (error) {
          console.log(error.response);
        });
    },
    loadProducts: function () {
      axios
        .get("/api/getproducts")
        .then((response) => {
          this.products = response.data;
        })
        .catch(function (error) {
          console.log(error.response);
        });
    },
  },
};
</script>
