<template>
  <div>
    <v-container
      class="d-flex flex-wrap"
    >
      <v-card
        class="mx-auto mb-10"
        min-width="400"
      >
        <v-card-title>
          <span class="title font-weight-light">{{idea.theme}}</span>
        </v-card-title>

        <v-card-text class="headline">
          {{idea.text}}
        </v-card-text>

        <v-card-actions>
          <v-list-item class="grow">
            <v-list-item-avatar>
              <v-icon
                x-large
                color="grey darken-2"
              >
                mdi-account-circle
              </v-icon>
            </v-list-item-avatar>

            <v-list-item-content>
              <v-list-item-title>{{idea.author}}</v-list-item-title>
            </v-list-item-content>

            <v-row
              align="center"
              justify="end"
            >
              <v-btn :disabled="(this.$store.state.apiToken == '' ? true : false)" fab x-small color="red lighten-1" @click="like(idea.id)">
                <v-icon color="white">
                  mdi-heart
                </v-icon>
              </v-btn>
              <span class="subheading ml-2 mr-2">{{idea.likes}}</span>
            </v-row>
          </v-list-item>
        </v-card-actions>
      </v-card>
    </v-container>
    <v-container class="d-flex flex-wrap justify-center">
        <v-btn @click="getIdea()" color="blue" x-large class="white--text">Случайная идея</v-btn>
    </v-container>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        idea: [],
        page: 1
      }
    },
    methods: {
        getIdea() {
          this.$axios.get(`http://localhost:8000/api/idea/random`)
          .then(response => {
            this.idea = response.data;
          });
        },
        like(id) {
          this.$axios.post(`http://localhost:8000/api/idea/like`, {
            id: id
          }, {
            headers: {
              Authorization: `Bearer ${this.$store.state.apiToken}`,
              Accept: 'application/json'
            }
          }).then(response => {
            this.getIdea();
          });
        }
    },
    mounted() {
      this.getIdea();
    }
  }
</script>