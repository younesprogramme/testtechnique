<template>
  <div class="form-group">
    <h2>Product list</h2>
    <span>Sort by</span>
    <select @change="sortBy($event)">
      <option selected value="">All</option>
      <option  v-for="option in options" v-bind:key="option.id" v-bind:value="option.value"
      :data-hex="option.sortby">
        {{ option.text }}
      </option>
    </select>
    <span>Filter by category</span>
    <select @change="filterbyCategory($event)">
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
      <button class="btn btn-warning" @click="deleteProduct(item.id)">Delete</button>
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
    filterbyCategory(event) {
      console.log(event.target.value);
      axios
        .post("/api/filterbycategory", { category: event.target.value })
        .then((response) => {
          console.log(response.data);
          this.products = response.data;
        })
        .catch(function (error) {
          console.log(error.response);
        });
    },
     sortBy(event) {
      axios
        .post("/api/sortby", {
          orderby: event.target.value,
          sortby: event.target.selectedOptions[0].dataset.hex,
        })
        .then((response) => {
          this.products = response.data;
          console.log(event.target.selectedOptions[0].dataset.hex);
        })
        .catch(function (error) {
          console.log(error.response);
        });
    },
     deleteProduct(id) {
      axios
        .post("api/deleteproduct", { id: id })
        .then((response) => {
          this.products = response.data;
          alert('Product deleted')
          this.loadProducts();
        })
        .catch(function (error) {
          console.log(error.response);
        });
    },
  },
};
</script>
