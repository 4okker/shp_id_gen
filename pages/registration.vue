<template>
  <v-container>
        <v-row>
            <v-col cols="4">
                <h1>Регистрация</h1>
                <v-form
                ref="form"
                v-model="valid"
                lazy-validation
                >
                    <v-text-field
                        v-model="username"
                        label="Имя"
                        :error="(error == '422' ? true : false)"
                        required
                    ></v-text-field>

                    <v-text-field
                        v-model="email"
                        label="Email"
                        :error="(error == '422' ? true : false)"
                        required
                    ></v-text-field>

                    <v-text-field
                        v-model="password"
                        label="Пароль"
                        type="password"
                        :error="(error == '422' ? true : false)"
                        required
                    ></v-text-field>

                    <v-btn
                        color="success"
                        class="mr-4"
                        @click="sing_up"
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
        email: '',
        password: '',
        username: '',
        error: 'none'
      }
    },
    methods: {
        sing_up() {
            this.$axios.post(`http://localhost:8000/api/register`, {
                email: this.email,
                password: this.password,
                name: this.username,
                device_name: 'web'
            }).then(response => {
                this.$store.commit('setToken', response.data.token);
                this.$store.commit('setUsername', response.data.username);
                this.$store.commit('setRights', response.data.rights);
                this.error = 'none';
                this.email = '';
                this.password = '';
                this.username = '';
                this.$router.push('/');
            }).catch(error => {
                console.log(error.response.status);
                this.error = error.response.status;
            });
        }
    },
    mounted() {
    }
  }
</script>