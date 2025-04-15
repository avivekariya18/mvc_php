function addComment(button) {
  const inputContainer = document.createElement("tr");
  inputContainer.className = "comment-box";
  const td = document.createElement("td");

  const textarea = document.createElement("textarea");
  textarea.placeholder = "Write your comment...";
  textarea.className = "form-control mb-2";
  textarea.rows = 3;
  textarea.name = "comment";

  td.appendChild(textarea);
  inputContainer.appendChild(td);

  const repliesContainer = button
    ? button.parentElement.querySelector(".replies")
    : document.querySelector("#question .replies");

  repliesContainer.appendChild(inputContainer);

  console.log(document.querySelector('table'));
}

function addreplay(){
 

    const inputContainer = document.createElement("tr");
  inputContainer.className = "comment-box";
  const td = document.createElement("td");

  const textarea = document.createElement("textarea");
  textarea.placeholder = "Write your comment...";
  textarea.className = "form-control mb-2";
  textarea.rows = 3;
  textarea.name = "comment";

  td.appendChild(textarea);
  inputContainer.appendChild(td);

  const repliesContainer = button
    ? button.parentElement.querySelector(".replies")
    : document.querySelector("#question .replies");

  repliesContainer.appendChild(inputContainer);

  console.log(document.querySelector('table'));
}

function saveCommentToDatabase() {
  const ticketId = document.getElementById("ticketId").value;
  const allTextareas = document.querySelectorAll("#question textarea");
  const allReplyButtons = document.querySelectorAll("button");
  allReplyButtons.forEach((btn) => {
    if (btn.textContent === "+ Add Reply") {
      btn.style.display = "none";
    }
  });
  allTextareas.forEach((textarea) => {
    const text = textarea.value.trim();
    if (text === "") return;

    const currentCommentBox = textarea.closest(".comment-box");
    let td = document.createElement('td');
    const parentCommentBox =
      currentCommentBox.parentElement.closest(".comment-box");
    const parentId = parentCommentBox?.getAttribute("data-comment-id") || null;
    console.log(parentCommentBox);
    currentCommentBox.innerHTML = "";

    const commentText = document.createElement("p");
    commentText.textContent = text;
    td.appendChild(commentText);

    const addReplyBtn = document.createElement("button");
    addReplyBtn.textContent = "+ Add Reply";
    addReplyBtn.className = "btn btn-outline-primary btn-sm me-2";
    addReplyBtn.onclick = function () {
      addComment(this);
    };
    td.appendChild(addReplyBtn);

    const nestedReplies = document.createElement("div");
    nestedReplies.className = "replies";
    td.appendChild(nestedReplies);

    currentCommentBox.appendChild(td);

    // $.ajax({
    //   url: "http://localhost/mvc_new/admin/replay_Index/commentsave",
    //   type: "POST",
    //   data: {
    //     parent_id: parentId,
    //     ticket_id: ticketId,
    //     comment: text,
    //   },
    //   success: function (response) {
    //     console.log("Comment saved. ID:", response);

    //     currentCommentBox.setAttribute("data-comment-id", response);
    //   },
    //   error: function () {
    //     console.error("Error saving comment.");
    //   },
    // });
  });

  document.querySelector("#question button.btn-primary").style.display = "none";
}
