<style>
.mult  { text-decoration: overline  }
.mult2 { padding-top: 1px;
         border-top: 1px solid; }
#output { font-size: 24 }
</style>

<div id="app">
  <input v-model="number">
  <button @click="translate">TRANSLATE</button>
  <br/><br/><br/>
  <div id="output" v-html="formatted(translation)"></div>
  <div id="explanation" v-html="status"></div>
</div>

<script src="https://unpkg.com/vue"></script>
<script src="https://unpkg.com/jquery"></script>
<script>
vm = new Vue({
  el: '#app',
  created: function () {
    this.status = this.message;
  },
  data: {
    number: '',
    translation: '',
    message: `
    <p>Feel free to try both Roman and Arabic numbers above.</p>
    <p>Positive integers and not too much funny business, please.</p>
    <p>For numbers over 3999 in Roman, a line over the number means "multiply this by 1000".</p>
    <p>Lines can stack, so a double overline means "multiply this by a million", and so on, but you may need to use some imagination for very large numbers.</p>
    <p>You can input very large Roman numbers by representing overlines with parentheses: e.g. ((CXXIII))(CDLVI)DCCLXXXIX = 123456789</p>
    <p>CAVEAT: currently only understands the most orthodox Roman format. So while you might like MIM to be interpreted as 1999, you're going to have to type
    in the full MCMXCIX unfortunately; right now MIM will be interepreted as 1001 + 1000 = 2001.</p>
    `,
    status: ''
  },
  methods: {
    translate: function () {
      let path = Number(this.number) ? '/fromArabic/' : '/fromRoman/';
      $.ajax({
        'method': 'GET',
        'url': path + this.number,
      })
      .done(res => {
        this.translation = res;
        this.status = this.message;
      })
      .fail(res => {
        this.translation = '';
        this.status = "Apologies, we had trouble parsing your input! Please email <a href='mailto:osirun@gmail.com'>osirun@gmail.com</a> if you think it should have been valid, and we'll see what we can do.";
      });
    },
    formatted: function (trans) {
      if (typeof trans === 'object') {
        result = ''
        keys = [];
        for (var key in trans) {
          keys.push(key);
        }
        keys.sort().reverse();
        len = keys.length;
        for (let i = 0; i < len; i++) {
            key = trans[keys[i]];
            curPos = len - i - 1;
          //for (let j = 1; j < len - i; j++) {
            if (curPos > 2)
              result += "<sup>" + curPos + "</sup>"
            if (curPos > 0)
              result += "<span class='mult mult" + curPos + "'>";
          //}
          result += key;
          //for (let j = 1; j < len - i; j++) {
            result += "</span>";
          //}
        }
        return result;
      }
      return trans;
    }
  }
});
</script>
