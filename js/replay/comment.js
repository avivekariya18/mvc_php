function openTextbox() {
  const td = event.target.closest("td");
  const input = document.createElement("input");
  input.type = "text";
  input.placeholder = "Enter comment";
  td.appendChild(document.createElement("br"));
  td.appendChild(input);
}

function save() {
  console.log("123");
  let complited1 = document.querySelectorAll("button");

  complited1.forEach((complit) => {
    if (complit.textContent == "complited") {
      if (complit.parentElement.nextSibling.querySelector("input") == null) {
        // console.log('compiles')
        complited(complit);
      }
    }
  });
  let input = document.querySelectorAll("input");
  input.forEach((i) => {
    text = i.value;
    console.log(i.parentElement.previousElementSibling);
    parent =
      i.parentElement.previousElementSibling.querySelector("span")
        ?.textContent || NULL;
    tId = document.getElementById("tId").textContent;
    max = document.getElementById("max_level").textContent;
    // console.log(tId);
    // console.log(text);
    // console.log(parent);
    ajaxCall(tId, text, parent,max);
    // window.location.reload();
  });
}

function ajaxCall(tid, cmt, pnid,max) {
  console.log("123");
  $.ajax({
    url: "http://localhost/mvc_new/admin/replay_index/commentsave",
    type: "post",
    data: {
      comment: cmt,
      parent_id: pnid,
      ticket_id: tid,
      max: max,
    },
    success: function (res) {
      console.log(res);
      window.location.reload();
    },
    error: function (err) {
      console.log(err);
    },
  });
}

function complited(button) {
  commentId = button.previousElementSibling.textContent;

  $.ajax({
    url: "http://localhost/mvc_new/admin/replay_index/activesave",
    type: "post",
    data: {
      comment_id: commentId,
    },
    success: function (res) {
      console.log(res);
      window.location.reload();
    },
    error: function (err) {
      console.log(err);
    },
  });
  
}
