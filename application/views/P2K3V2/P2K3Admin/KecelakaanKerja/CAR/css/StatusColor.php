<style>
  .status {
    padding: 0.2em 0.7em;
    border-radius: 8px;
  }

  .status:hover {
    filter: brightness(90%);
  }

  .status.process {
    background-color: #ffe266;
    color: #d17c00;
  }

  .status.reject {
    background-color: tomato;
    color: red;
  }

  .status.verified {
    background-color: #d3f8d7;
    color: #17d100;
  }

  .status.revisi {
    background-color: #ffb997;
    color: #d54f00;
  }

  .status.closed {
    background-color: #e8e8e8;
    color: black;
  }

  .status.open {
    background-color: lightcyan;
    color: cyan;
  }

  a {
    padding: 0.5em 0.75em;
    transition: ease-in 0.1s;
  }

  a:hover {
    border-radius: 4px;
    background: #e4f0ff;
  }
</style>