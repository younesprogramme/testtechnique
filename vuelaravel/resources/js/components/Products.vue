<template>
  <div class="form-group">
    <h2>Product list</h2>
    <form v-on:submit.prevent="checkForm">
      <div class="form-group">
        <input id="id" v-model="product.id" type="hidden" name="id" />
        <input
          class="form-control"
          id="name"
          v-model="product.name"
          type="text"
          name="name"
          placeholder="Name"
          size="50"
        />
      </div>
      <br />
      <div class="form-group">
        <input
          class="form-control"
          id="price"
          v-model="product.price"
          type="text"
          name="price"
          placeholder="Price"
          size="50"
        />
      </div>
      <br />
      <div class="form-group">
        <textarea
          class="form-control"
          id="description"
          v-model="product.description"
          type="text"
          name="description"
          cols="51"
          placeholder="description"
        />
      </div>
      <br />
      <div class="form-group">
        <select
          @change="selectCategory($event)"
          class="form-select form-select-lg mb-3"
        >
          <option selected value="">Choose category</option>
          <option v-for="category in categories" v-bind:key="category.id">
            {{ category.name }}
          </option>
        </select>
      </div>
      <div>
        <strong>Upload Image:</strong>
        <input type="file" class="form-control" v-on:change="onImageChange" />
      </div>
      <br/>
      <p v-if="errors.length">
    <b>Please correct the following error(s):</b>
    <ul>
      <li v-for="error in errors">{{ error }}</li>
    </ul>
  </p>
      <p>
        <input type="submit" value="Submit" class="btn btn-success" />
      </p>
    </form>
    <span>Sort by</span>
    <select @change="sortBy($event)">
      <option selected value="">All</option>
      <option
        v-for="option in options"
        v-bind:key="option.id"
        v-bind:value="option.value"
        :data-hex="option.sortby"
      >
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
    <hr />
    <div class="card card-body" v-for="item in products" v-bind:key="item.id">
      <img :src="item.image" alt="Girl in a jacket" width="150" height="200" />
      <span
        ><strong>{{ item.name }} DH</strong></span
      >
      {{item.description}}
      <span
        ><strong>{{ item.price }} DH</strong></span
      >
      <button class="btn btn-info" @click="editProduct(item.id)">Edit</button>
      <button class="btn btn-warning" @click="deleteProduct(item.id)">
        Delete
      </button>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data: function () {
    return {
      errors: [],
      product:
        {  id: '', name: '', description: "" ,price:'',category:''}
      ,
      options: [
        { text: "Name : A to Z", value: "asc", id: "1", sortby: "name" },
        { text: "Name : Z to A", value: "desc", id: "2", sortby: "name" },
        { text: "Price : low to high", value: "asc", id: "3", sortby: "price" },
        {text: "Price : high to low", value: "desc", id: "4", sortby: "price"},
        ],
      products: [],
      categories: [],
      selectedImage:'',
      imageUrl:[],
      upid:''
    };
  },
  created() {
    this.loadProducts();
    this.loadCategories();
  },
  methods: {
    checkForm: function (e) {
      if (this.product.name && this.product.description && this.product.price) {
        this.addProduct();
        return true;
      }
      this.errors = [];
      if (!this.product.name) {
        this.errors.push('Name required.');
      }
      if (!this.product.description) {
        this.errors.push('Description required.');
      }
      if (!this.product.price) {
        this.errors.push('price required.');
      }
      e.preventDefault();
    },
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
    selectCategory(event){
      this.product.category= event.target.value;
      console.log(this.product.category);
    },
    filterbyCategory(event) {
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
      axios.post("api/deleteproduct", { id: id })
        .then((response) => {
          this.products = response.data;
          alert('Product deleted')
          this.loadProducts();
        })
        .catch(function (error) {
          console.log(error.response);
        });
    },
     addProduct() {
       if (this.product.id=="") {
     this.onUpload();
      axios
        .post("/api/createproduct", {
          name: this.product.name,
          description: this.product.description,
          price: this.product.price,
          category: this.product.category,
          image: "../storage/"+this.imageUrl
        })
        .then((response) => {
          // console.log(response.data);
          alert(response.data);
        })
        .catch(function (error) {
          console.log(error.response);
        });
         }
       else{
         this.updateProduct(this.product.id);
       }
    },
    editProduct(id){

      axios.post("api/showproduct", { id: id })
        .then((response) => {
          //this.products = response.data;
          this.product=response.data;

          console.log(this.product.id)
         // this.loadProducts();
        })
        .catch(function (error) {
          console.log(error.response);
        });
    },
    updateProduct(id){
      console.log(this.product.id);
      axios.post("api/updateproduct", {
          id: this.product.id,
          name: this.product.name,
          description: this.product.description,
          price: this.product.price,
          // image: this.image,
          category: this.product.category
          })

        .then((response) => {
          this.product=response.data;
          console.log(response.data)
        })
        .catch(function (error) {
          console.log(error.response);
        });
    },

     onImageChange(e) {
      this.selectedImage = event.target.files[0];
       console.log(this.selectedImage );
       },
     onUpload() {
      const fd = new FormData();
      this.imageUrl="";
      console.log(this.imageUrl);
      const config = {
        headers: { 'content-type': 'multipart/form-data' }
        }
      fd.append("image", this.selectedImage,config);
      axios.post('/api/upload',fd)
      .then(function (response) {

        console.log(response.data.success);
        })
    },
  },
};
</script>
