<template>
  <form :action="id ? '/admin/' + id : '/admin'" method="post">
    <input type="hidden" name="_token" :value="csrf" />
    <input type="hidden" name="html_content" :value="compiled" />
    <div class="row my-4">
      <div class="col">
        <label for="markdown_content" class="form-label">Markdown content</label>
        <textarea
            :value="content"
            @input="update"
            rows="20"
            name="markdown_content"
            id="markdown_content"
            class="form-control"></textarea>
      </div>
      <div class="col">
        <label class="form-label">Rendered</label>
        <div v-html="compiled"></div>
      </div>
    </div>
    <button class="btn btn-primary" :disabled="!content">
      Send
    </button>
  </form>
</template>

<script>
import _ from 'lodash';
import Marked from 'marked';

export default {
  name: "PostForm",
  data: () => ({
    id: null,
    content: '',
    csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
  }),
  computed: {
    compiled: function () {
      return Marked(this.content);
    },
  },
  methods: {
    update: _.debounce(function (e) {
      this.content = e.target.value;
    }, 300)
  },
  mounted() {
    if (window.postData && window.postData.markdown_content) {
      this.content = window.postData.markdown_content;
    }

    if (window.postData && window.postData.id) {
      this.id = window.postData.id;
    }
  }
}
</script>
