<template>
  <div>
    <h2 class="center">{{ title }}</h2>
    <div v-text="message"></div>
    <ul>
      <li :key="word.id" v-for="word in words">{{ word }}</li>
    </ul>
    <button v-on:click="reverseMessage('message')">Reverse Message</button>
    <button v-on:click="reverseMessage('title')">Reverse Title</button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      message: `A list of words ${new Date().toLocaleString()}`,
      words: [],
      title: 'My Application',
    };
  },
  methods: {
    reverseMessage: function(what) {
      this[what] = this[what]
        .split('')
        .reverse()
        .join('');
    },
  },
  watch: {
    title: function(val, oldVal) {
      console.log('new: %s, old: %s', val, oldVal);
    },
    message: function(val, oldVal) {
      console.log('new: %s, old: %s', val, oldVal);
    },
  },
  beforeCreate() {
    console.log('before create');
  },
  created() {
    console.log('created');
  },
  beforeUpdate() {
    console.log('before update');
  },
  updated() {
    console.log('updated');
  },
  beforeMount() {
    console.log('before mount');
  },
  mounted() {
    console.log('mounted');
    let el = document.querySelector('div[data-words]');
    this.words = [...el.dataset.words.split(',')];
  },
};
</script>

<style>
.center {
  text-align: center;
}
</style>
