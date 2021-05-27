<template>
  <v-app>
    <v-navigation-drawer v-model="drawer" fixed app>
      <v-list>
        <v-list-item v-if="this.$store.state.apiToken != ''">
          <v-list-item-content>
            <v-list-item-title class="title">{{this.$store.state.userName}}</v-list-item-title>
            <v-list-item-subtitle v-if="this.$store.state.userRights.includes('server:update')">Админ</v-list-item-subtitle>
            <v-list-item-subtitle v-else-if="this.$store.state.userRights.includes('idea:create')">Пользователь</v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>

        <v-list-item to="/" router exact>
          <v-list-item-action>
            <v-icon>mdi-home</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title v-text="'Главная'" />
          </v-list-item-content>
        </v-list-item>

        <v-list-item v-if="this.$store.state.userRights.includes('server:update')" to="/control" router exact>
          <v-list-item-action>
            <v-icon>mdi-database-edit</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title v-text="'Управление'" />
          </v-list-item-content>
        </v-list-item>

        <v-list-item to="/random" router exact>
          <v-list-item-action>
            <v-icon>mdi-head-lightbulb</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title v-text="'Случайная идея'" />
          </v-list-item-content>
        </v-list-item>

        <v-list-item v-if="this.$store.state.userRights.includes('idea:create')" to="/create" router exact>
          <v-list-item-action>
            <v-icon>mdi-lightbulb-on</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title v-text="'Своя идея'" />
          </v-list-item-content>
        </v-list-item>

        <v-list-item v-if="this.$store.state.apiToken == ''" to="/login" router exact>
          <v-list-item-action>
            <v-icon>mdi-login-variant</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title v-text="'Вход'" />
          </v-list-item-content>
        </v-list-item>

        <v-list-item v-if="this.$store.state.apiToken == ''" to="/registration" router exact>
          <v-list-item-action>
            <v-icon>mdi-login-variant</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title v-text="'Регистрация'" />
          </v-list-item-content>
        </v-list-item>
        
      </v-list>
    </v-navigation-drawer>
    <v-app-bar fixed app>
      <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
      <v-col><v-toolbar-title v-text="title" /></v-col>
      <v-col v-if="this.$store.state.apiToken != ''" class="text-right"><v-btn @click="exit()" color="red lighten-1" class="white--text">Выйти из аккаунта</v-btn></v-col>
    </v-app-bar>
    <v-content class="blue-grey lighten-5">
      <v-container>
        <nuxt />
      </v-container>
    </v-content>

    <v-footer fixed app>
      <span>&copy; {{ new Date().getFullYear() }} Мы в Pi*V*O</span>
    </v-footer>
  </v-app>
</template>

<script>
export default {
  data() {
    return {
      drawer: false,
      // items: [
      //   {
      //     icon: "mdi-home",
      //     title: "Главная",
      //     to: "/"
      //   },
      //   {
      //     icon: "mdi-database-edit",
      //     title: "Управление",
      //     to: "/admin"
      //   },
      //   {
      //     icon:"mdi-head-lightbulb",
      //     title: "Генератор идей",
      //     to: "/generator"
      //   },
      //   {
      //     icon: "mdi-lightbulb-on",
      //     title: "Своя идея",
      //     to: "/create"
      //   },
      //   {
      //     icon: "mdi-login-variant",
      //     title: "Вход/Регистрация",
      //     to: "/login"
      //   }
      // ],

      right: true,
      rightDrawer: false,
      title: "Генератор идей"
    };
  },
  methods: {
        exit() {
          this.$store.commit('setToken', '');
          this.$store.commit('setUsername', '');
          this.$store.commit('setRights', []);
        }
  }
};
</script>
