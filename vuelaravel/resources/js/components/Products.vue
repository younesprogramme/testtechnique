<template>
  <div class="form-group">
    <h2>Product list</h2>
    <span>Sort by</span>
    <select>
      <option selected value="">All</option>
      <option  v-for="option in options" v-bind:key="option.id" v-bind:value="option.value"
      :data-hex="option.sortby">
        {{ option.text }}
      </option>
    </select>
    <span>Filter by category</span>
    <select>
      <option selected value="">All</option>
      <option v-for="category in categories" v-bind:key="category.id">
        {{ category.name }}
      </option>
    </select>
    <hr/>
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
      options: [
        { text: "Name : A to Z", value: "asc", id: "1", sortby: "name" },
        { text: "Name : Z to A", value: "desc", id: "2", sortby: "name" },
        { text: "Price : low to high", value: "asc", id: "3", sortby: "price" },
        {text: "Price : high to low", value: "desc", id: "4", sortby: "price"},
        ],
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
