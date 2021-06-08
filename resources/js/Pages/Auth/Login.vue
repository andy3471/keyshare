<template>
  <guest-layout>
    <template #header>
      Login
    </template>

    <b-container>
      <jet-validation-errors />

      <div v-if="status">
        {{ status }}
      </div>

      <form @submit.prevent="submit">
        <b-form-group
          id="email"
          label="Email address:"
          label-for="email"
        >
          <b-form-input
            id="email"
            v-model="form.email"
            type="email"
            required
            autofocus
          />
        </b-form-group>

        <b-form-group
          id="password"
          label="Password:"
          label-for="password"
        >
          <b-form-input
            id="password"
            v-model="form.password"
            type="password"
            required
            autocomplete="current-password"
          />
        </b-form-group>

        <div>
          <label class="flex items-center">
            <b-checkbox
              v-model="form.remember"
              name="remember"
            >Remember me</b-checkbox>
          </label>
        </div>

        <div>
          <b-button
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
            type="submit"
            variant="primary"
          >
            Login
          </b-button>
          <b-link
            v-if="canResetPassword"
            :href="route('password.request')"
          >
            Forgot your password?
          </b-link>
          <b-link :href="route('register')">
            Register
          </b-link>
          <br>
          <a :href="route('login.steam')"><img src="/images/steamlogin.png"></a>
<!--          TODO needs images -->
          <a :href="route('login.discord')">Login with discord</a>
          <a :href="route('login.twitch')">Login with twitch</a>
        </div>
      </form>
    </b-container>
  </guest-layout>
</template>

<script>
import JetValidationErrors from '@/Jetstream/ValidationErrors'
import GuestLayout from '@/Layouts/GuestLayout'

export default {
  components: {
    JetValidationErrors,
    GuestLayout
  },

  props: {
    canResetPassword: Boolean,
    status: String
  },

  data () {
    return {
      form: this.$inertia.form({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
      })
    }
  },

  methods: {
    submit () {
      this.form
        .transform(data => ({
          ...data,
          remember: this.form.remember ? 'on' : ''
        }))
        .post(this.route('login'), {
          onFinish: () => this.form.reset('password')
        })
    }
  }
}
</script>
