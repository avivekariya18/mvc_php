// function addComment(button) {
//   const inputContainer = document.createElement("tr");
//   inputContainer.className = "comment-box";
//   const td = document.createElement("td");

//   const textarea = document.createElement("textarea");
//   textarea.placeholder = "Write your comment...";
//   textarea.className = "form-control mb-2";
//   textarea.rows = 3;
//   textarea.name = "comment";

//   td.appendChild(textarea);
//   inputContainer.appendChild(td);

//   const repliesContainer = button
//     ? button.parentElement.querySelector(".replies")
//     : document.querySelector("#question .replies");

//   repliesContainer.appendChild(inputContainer);

//   console.log(document.querySelector('table'));
// }

// function addreplay(){

//     const inputContainer = document.createElement("tr");
//   inputContainer.className = "comment-box";
//   const td = document.createElement("td");

//   const textarea = document.createElement("textarea");
//   textarea.placeholder = "Write your comment...";
//   textarea.className = "form-control mb-2";
//   textarea.rows = 3;
//   textarea.name = "comment";

//   td.appendChild(textarea);
//   inputContainer.appendChild(td);

//   const repliesContainer = button
//     ? button.parentElement.querySelector(".replies")
//     : document.querySelector("#question .replies");

//   repliesContainer.appendChild(inputContainer);

//   console.log(document.querySelector('table'));
// }

// function saveCommentToDatabase() {
//   const ticketId = document.getElementById("ticketId").value;
//   const allTextareas = document.querySelectorAll("#question textarea");
//   const allReplyButtons = document.querySelectorAll("button");
//   allReplyButtons.forEach((btn) => {
//     if (btn.textContent === "+ Add Reply") {
//       btn.style.display = "none";
//     }
//   });
//   allTextareas.forEach((textarea) => {
//     const text = textarea.value.trim();
//     if (text === "") return;

//     const currentCommentBox = textarea.closest(".comment-box");
//     let td = document.createElement('td');
//     const parentCommentBox =
//       currentCommentBox.parentElement.closest(".comment-box");
//     const parentId = parentCommentBox?.getAttribute("data-comment-id") || null;
//     console.log(parentCommentBox);
//     currentCommentBox.innerHTML = "";

//     const commentText = document.createElement("p");
//     commentText.textContent = text;
//     td.appendChild(commentText);

//     const addReplyBtn = document.createElement("button");
//     addReplyBtn.textContent = "+ Add Reply";
//     addReplyBtn.className = "btn btn-outline-primary btn-sm me-2";
//     addReplyBtn.onclick = function () {
//       addComment(this);
//     };
//     td.appendChild(addReplyBtn);

//     const nestedReplies = document.createElement("div");
//     nestedReplies.className = "replies";
//     td.appendChild(nestedReplies);

//     currentCommentBox.appendChild(td);

//     // $.ajax({
//     //   url: "http://localhost/mvc_new/admin/replay_Index/commentsave",
//     //   type: "POST",
//     //   data: {
//     //     parent_id: parentId,
//     //     ticket_id: ticketId,
//     //     comment: text,
//     //   },
//     //   success: function (response) {
//     //     console.log("Comment saved. ID:", response);

//     //     currentCommentBox.setAttribute("data-comment-id", response);
//     //   },
//     //   error: function () {
//     //     console.error("Error saving comment.");
//     //   },
//     // });
//   });

//   document.querySelector("#question button.btn-primary").style.display = "none";
// }

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
        complited(complit);
      }
    }
  });
  let input = document.querySelectorAll("input");
  input.forEach((i) => {
    text = i.value;
    console.log(i.parentElement.previousElementSibling);
    if (!i.parentElement.previousElementSibling.querySelector("span")) {
      parent =
        i.parentElement.previousElementSibling.querySelector(
          "span"
        )?.textContent;
      }
      parent = null;
      tId = document.getElementById("tId").textContent;
      console.log(tId);
      console.log(text);
      console.log(parent);
    ajaxCall(tId, text, parent);
  });
}

function ajaxCall(tid, cmt, pnid) {
  console.log("123");
  $.ajax({
    url: "http://localhost/mvc_new/admin/replay_index/commentsave",
    type: "post",
    data: {
      comment: cmt,
      parent_id: pnid,
      ticket_id: tid,
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
  // let arr1 = button.parentElement.parentElement.querySelectorAll("td");
  // arr1.forEach((td) => {
  // td.setAttribute('rowspan',td.getAttribute("rowspan")-1);
  // if (td.getAttribute("rowspan") == 1) {
  // commentId = td.querySelector("span").textContent;
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
  // } else {
  //   td.setAttribute("rowspan", td.getAttribute("rowspan") - 1);
  // }
  // });
}
