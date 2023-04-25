<template>
  <div class="ingredient-list">
    <h2>Ingredients</h2>
    <ul>
      <li v-for="ingredient in ingredients" :key="ingredient.id">
        <div class="ingredient-item">
          <div class="ingredient-info">
            <div class="ingredient-name">{{ ingredient.name }}</div>
            <div class="ingredient-image">
              <img :src="'/storage/' + ingredient.image_path" alt="">
            </div>
          </div>
          <div class="ingredient-actions">
            <router-link :to="{ name: 'ingredients.edit', params: { id: ingredient.id } }">Edit</router-link>
            <button @click="deleteIngredient(ingredient.id)">Delete</button>
          </div>
        </div>
      </li>
    </ul>
    <router-link :to="{ name: 'ingredients.create' }">Create New Ingredient</router-link>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      ingredients: []
    }
  },
  created() {
    this.fetchIngredients();
  },
  methods: {
    fetchIngredients() {
      axios.get('/api/ingredients')
        .then(response => {
          this.ingredients = response.data;
        })
        .catch(error => console.log(error));
    },
    deleteIngredient(id) {
      if (confirm('Are you sure you want to delete this ingredient?')) {
        axios.delete('/api/ingredients/' + id)
          .then(response => {
            this.ingredients = this.ingredients.filter(ingredient => ingredient.id !== id);
          })
          .catch(error => console.log(error));
      }
    }
  }
}
</script>

<style lang="scss">
.ingredient-list {
  margin-top: 20px;
  
  h2 {
    font-size: 24px;
    margin-bottom: 10px;
  }
  
  ul {
    list-style: none;
    padding: 0;
    margin: 0;
    
    li {
      border: 1px solid #ccc;
      border-radius: 5px;
      padding: 10px;
      margin-bottom: 10px;
      
      .ingredient-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        
        .ingredient-info {
          display: flex;
          align-items: center;
          
          .ingredient-name {
            font-size: 20px;
            font-weight: bold;
            margin-right: 20px;
          }
          
          .ingredient-image {
            img {
              max-width: 100px;
              max-height: 100px;
              object-fit: cover;
            }
          }
        }
        
        .ingredient-actions {
          button {
            padding: 5px 10px;
            background-color: red;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 10px;
          }
        }
      }
    }
  }
  
  a {
    display: inline-block;
    padding: 10px;
    background-color: #333;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    margin-top: 20px;
  }
}
</style>
