<template>
  <button :class="{ fullWidth: fullWidth }" :disabled="disabled" @click="onClick">
    <slot></slot>
  </button>
</template>

<script>
import { THEMES } from './config.js'
export default {
  name: 'BaseButton',
  emits: ['click'],
  props: {
    value: {
      type: String,
      default: ''
    },
    fullWidth: {
      type: Boolean,
      default: false
    },
    disabled: {
      type: Boolean,
      default: false
    },
    theme: {
      type: String,
      default: THEMES.PRIMARY
    }
  },
  methods: {
    onClick() {
      this.$emit('click')
    }
  },
  computed: {
    themeObj() {
      const theme = {
        [THEMES.PRIMARY]: {
          bg: '#137996',
          hover: '#0c576c',
          color: '#fff',
          border: 'none',
          hoverColor: '#fff'
        },
        [THEMES.SECONDARY]: {
          bg: '#008080',
          hover: '#006666',
          color: '#fff',
          border: 'none',
          hoverColor: '#fff'
        },
        [THEMES.OUTLINE]: {
          bg: '#ffffff',
          hover: '#137996',
          color: '#137996',
          border: '1px solid #137996',
          hoverColor: '#fff'
        }
      }
      const type = this.theme.toUpperCase() || THEMES.PRIMARY
      return theme[type]
    }
  }
}
</script>

<style lang="scss" scoped>
@import '@/utilities/css/vars/vars.scss';
button {
  background-color: v-bind('themeObj.bg');
  color: v-bind('themeObj.color');
  font-size: large;
  font-family: $FONT_BOLD;
  border: v-bind('themeObj.border');
  border-radius: 5px;
  padding: 10px 20px;
  cursor: pointer;
  transition: background-color 0.2s;

  &.fullWidth {
    width: 100%;
  }
  &:hover {
    background-color: v-bind('themeObj.hover');
    color: v-bind('themeObj.hoverColor');
  }
  &:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    &:hover,
    &:active {
      background: v-bind('themeObj.bg');
    }
  }
}
</style>
