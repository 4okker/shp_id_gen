<template>
  <div>
    <div class="text-center">
      <v-pagination
        v-model="page"
        :length="ideas.last_page"
        :total-visible="7"
        @input="getIdeas"
      ></v-pagination>
    </div>
    <v-container
      class="d-flex flex-wrap"
    >
      <v-card
        v-for="(idea, i) in ideas.data"
        :key="i"

        class="mx-auto mb-10"
        min-width="500"
        max-width="500"
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
              <v-btn :disabled="(vue.$store.state.apiToken == '' ? true : false)" fab x-small :color="(idea.liked == true ? 'grey' : 'red') + ' lighten-1'" @click="like(idea.id)">
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
    <div class="text-center">
      <v-pagination
        v-model="page"
        :length="ideas.last_page"
        :total-visible="7"
        @input="getIdeas"
      ></v-pagination>
    </div>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        ideas: [],
        page: 1,
        vue: this
      }
    },
    methods: {
        getIdeas() {
          this.$axios.get(`http://localhost:8000/api/idea/all?page=${this.page}`)
          .then(response => {
            this.ideas = response.data;
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
            this.getIdeas();
          });
        }
    },
    mounted() {
      this.getIdeas();
    }
  }
</script>