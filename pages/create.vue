<template>
  <v-container>
        <v-row>
            <v-col cols="4">
                <h1>Добавить идею</h1>
                <v-form
                ref="form"
                v-model="valid"
                lazy-validation
                >
                    <v-text-field
                        v-model="theme"
                        label="Тема"
                        :error="(error == '422' ? true : false)"
                        required
                    ></v-text-field>

                    <v-textarea
                      v-model="text"
                      label="Текст"
                      :error="(error == '422' ? true : false)"
                      required
                    >
                    </v-textarea>

                    <v-btn
                        color="success"
                        class="mr-4"
                        @click="create()"
                    >
                        Отправить
                    </v-btn>
                </v-form>
            </v-col>
        </v-row>
      </v-container>
</template>

<script>
  export default {
    data () {
      return {
        theme: '',
        text: '',
        error: 'none'
      }
    },
    methods: {
        create() {
            this.$axios.post(`http://localhost:8000/api/idea/create`, {
              theme: this.theme,
              text: this.text
            }, {
              headers: {
                Authorization: `Bearer ${this.$store.state.apiToken}`,
                Accept: 'application/json'
              }
            }).then(response => {
              if (response.data.status == 'bad request') {
                this.error = 422;
              } else {
                this.$router.push(`/idea/${response.data.id}`);
              }
            });
        }
    },
    mounted() {
    }
  }
</script>