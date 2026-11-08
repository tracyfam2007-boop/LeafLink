const notification = document.querySelector(".notification");
const notificationDropdown = document.querySelector(".notification-dropdown");

const profileMenu = document.querySelector(".profile-menu");
const profileDropdown = document.querySelector(".profile-dropdown");

notification.addEventListener("click", function(e){
    e.stopPropagation();
    notificationDropdown.classList.toggle("show");
    profileDropdown.classList.remove("show");
});

profileMenu.addEventListener("click", function(e){
    e.stopPropagation();
    profileDropdown.classList.toggle("show");
    notificationDropdown.classList.remove("show");
});

document.addEventListener("click", function(){
    notificationDropdown.classList.remove("show");
    profileDropdown.classList.remove("show");
});

const modal = document.getElementById("viewModal");

if(modal){

    const viewButtons = document.querySelectorAll(".view-btn");
    const closeButton = document.getElementById("closeModalBtn");
    const closeIcon = document.querySelector(".close-modal");
    const participantIdRow = document.getElementById("participantIdRow");
    const participantTypeRow = document.getElementById("participantTypeRow");
    const facultyRow = document.getElementById("facultyRow");
    const pointRow = document.getElementById("pointRow");

    viewButtons.forEach(function(button){

        button.addEventListener("click", function(){

            document.getElementById("viewUserId").textContent = this.dataset.id;
            document.getElementById("viewFullName").textContent = this.dataset.name;
            document.getElementById("viewEmail").textContent = this.dataset.email;
            document.getElementById("viewRole").textContent = this.dataset.role;
            document.getElementById("viewPhone").textContent = this.dataset.phone;
            document.getElementById("viewDob").textContent = this.dataset.dob;

            document.getElementById("viewParticipantId").textContent = this.dataset.participant;
            document.getElementById("viewParticipantType").textContent = this.dataset.type;
            document.getElementById("viewFaculty").textContent = this.dataset.faculty;
            document.getElementById("viewPointBalance").textContent = this.dataset.points;

            if(this.dataset.role == "Participant"){
                participantIdRow.classList.add("show");
                participantTypeRow.classList.add("show");
                facultyRow.classList.add("show");
                pointRow.classList.add("show");
            }else{
                participantIdRow.classList.remove("show");
                participantTypeRow.classList.remove("show");
                facultyRow.classList.remove("show");
                pointRow.classList.remove("show");
            }

            modal.classList.add("show");

        });

    });

    closeButton.addEventListener("click", function(){
        modal.classList.remove("show");
    });

    closeIcon.addEventListener("click", function(){
        modal.classList.remove("show");
    });

    window.addEventListener("click", function(event){
        if(event.target == modal){
            modal.classList.remove("show");
        }
    });

}

const addUserModal = document.getElementById("addUserModal");

if(addUserModal){

    const addUserButton = document.querySelector(".add-btn");
    const closeAddButton = document.querySelector(".close-add-modal");
    const cancelAddButton = document.getElementById("cancelAddUser");
    const roleSelect = document.getElementById("roleSelect");
    const participantSection = document.getElementById("participantSection");

    addUserButton.addEventListener("click", function(){
        document.getElementById("addUserForm").reset();
        participantSection.style.display = "none";
        addUserModal.classList.add("show");
    });

    closeAddButton.addEventListener("click", function(){
        addUserModal.classList.remove("show");
    });

    cancelAddButton.addEventListener("click", function(){
        addUserModal.classList.remove("show");
    });

    window.addEventListener("click", function(event){
        if(event.target == addUserModal){
            addUserModal.classList.remove("show");
        }
    });

    roleSelect.addEventListener("change", function(){

        if(this.value == "Participant"){
            participantSection.style.display = "block";
        }else{
            participantSection.style.display = "none";
        }
    });

}

const editUserModal = document.getElementById("editUserModal");

if(editUserModal){

    const editButtons = document.querySelectorAll(".edit-btn");
    const closeEditButton = document.querySelector(".close-edit-modal");
    const cancelEditButton = document.getElementById("cancelEditUser");

    editButtons.forEach(function(button){

        button.addEventListener("click", function(){

            document.getElementById("editUserId").value = this.dataset.id;
            document.getElementById("editUserIdDisplay").value = this.dataset.id;
            document.getElementById("editFullName").value = this.dataset.name;
            document.getElementById("editEmail").value = this.dataset.email;
            document.getElementById("editPhone").value = this.dataset.phone;
            document.getElementById("editDob").value = this.dataset.dob;
            document.getElementById("editRole").value = this.dataset.role;
            editUserModal.classList.add("show");
        });
    });

    closeEditButton.addEventListener("click", function(){
        editUserModal.classList.remove("show");
    });

    cancelEditButton.addEventListener("click", function(){
        editUserModal.classList.remove("show");
    });

    window.addEventListener("click", function(event){
        if(event.target == editUserModal){
            editUserModal.classList.remove("show");
        }
    });
}

const deleteUserModal = document.getElementById("deleteUserModal");

if(deleteUserModal){

    const deleteButtons = document.querySelectorAll(".delete-btn");
    const closeDeleteButton = document.querySelector(".close-delete-modal");
    const cancelDeleteButton = document.getElementById("cancelDeleteUser");

    deleteButtons.forEach(function(button){

        button.addEventListener("click", function(){

            document.getElementById("deleteUserId").textContent = this.dataset.id;
            document.getElementById("deleteFullName").textContent = this.dataset.name;
            document.getElementById("deleteRole").textContent = this.dataset.role;
            document.getElementById("deleteUserIdHidden").value = this.dataset.id;
            deleteUserModal.classList.add("show");
        });
    });

    closeDeleteButton.addEventListener("click", function(){
        deleteUserModal.classList.remove("show");
    });

    cancelDeleteButton.addEventListener("click", function(){
        deleteUserModal.classList.remove("show");
    });

    window.addEventListener("click", function(event){
        if(event.target == deleteUserModal){
            deleteUserModal.classList.remove("show");
        }
    });
}

const viewActivityModal = document.getElementById("viewActivityModal");

if(viewActivityModal){

    const viewButtons = document.querySelectorAll(".view-btn");
    const closeButton = document.getElementById("closeActivityModalBtn");
    const closeIcon = viewActivityModal.querySelector(".close-modal");

    viewButtons.forEach(function(button){

        button.addEventListener("click", function(){

            document.getElementById("viewActivityId").textContent = this.dataset.id;
            document.getElementById("viewActivityName").textContent = this.dataset.name;
            document.getElementById("viewDescription").textContent = this.dataset.description;
            document.getElementById("viewCategory").textContent = this.dataset.category;
            document.getElementById("viewPoints").textContent = this.dataset.points;
            document.getElementById("viewRules").textContent = this.dataset.rules;
            document.getElementById("viewStatus").textContent = this.dataset.status;
            viewActivityModal.classList.add("show");
        });
    });

    closeButton.addEventListener("click", function(){
        viewActivityModal.classList.remove("show");
    });

    closeIcon.addEventListener("click", function(){
        viewActivityModal.classList.remove("show");
    });

    window.addEventListener("click", function(event){
        if(event.target == viewActivityModal){
            viewActivityModal.classList.remove("show");
        }
    });
}

const addActivityModal = document.getElementById("addActivityModal");

if(addActivityModal){

    const addActivityButton = document.querySelector(".add-btn");
    const closeAddActivityButton = document.querySelector(".close-add-activity-modal");
    const cancelAddActivityButton = document.getElementById("cancelAddActivity");

    addActivityButton.addEventListener("click", function(){
        document.getElementById("addActivityForm").reset();
        addActivityModal.classList.add("show");
    });

    closeAddActivityButton.addEventListener("click", function(){
        addActivityModal.classList.remove("show");
    });

    cancelAddActivityButton.addEventListener("click", function(){
        addActivityModal.classList.remove("show");
    });

    window.addEventListener("click", function(event){
        if(event.target == addActivityModal){
            addActivityModal.classList.remove("show");
        }
    });
}

const editActivityModal = document.getElementById("editActivityModal");

if(editActivityModal){

    const editButtons = document.querySelectorAll(".edit-btn");
    const closeEditActivityButton = document.querySelector(".close-edit-activity-modal");
    const cancelEditActivityButton = document.getElementById("cancelEditActivity");

    editButtons.forEach(function(button){

        button.addEventListener("click", function(){

            document.getElementById("editActivityId").value = this.dataset.id;
            document.getElementById("editActivityIdDisplay").value = this.dataset.id;
            document.getElementById("editActivityName").value = this.dataset.name;
            document.getElementById("editDescription").value = this.dataset.description;
            document.getElementById("editCategory").value = this.dataset.category;
            document.getElementById("editPoints").value = this.dataset.points;
            document.getElementById("editRules").value = this.dataset.rules;
            document.getElementById("editStatus").value = this.dataset.status;
            editActivityModal.classList.add("show");

        });

    });

    closeEditActivityButton.addEventListener("click", function(){
        editActivityModal.classList.remove("show");
    });

    cancelEditActivityButton.addEventListener("click", function(){
        editActivityModal.classList.remove("show");
    });

    window.addEventListener("click", function(event){
        if(event.target == editActivityModal){
            editActivityModal.classList.remove("show");
        }
    });
}

const deleteActivityModal = document.getElementById("deleteActivityModal");

if(deleteActivityModal){

    const deleteActivityButtons = document.querySelectorAll(".delete-btn");
    const closeDeleteButton = document.querySelector(".close-delete-activity-modal");
    const cancelDeleteButton = document.getElementById("cancelDeleteActivity");

    deleteActivityButtons.forEach(function(button){

        button.addEventListener("click", function(){

            document.getElementById("deleteActivityId").textContent = this.dataset.id;
            document.getElementById("deleteActivityName").textContent = this.dataset.name;
            document.getElementById("deleteActivityIdHidden").value = this.dataset.id;
            deleteActivityModal.classList.add("show");

        });

    });

    closeDeleteButton.addEventListener("click", function(){
        deleteActivityModal.classList.remove("show");
    });

    cancelDeleteButton.addEventListener("click", function(){
        deleteActivityModal.classList.remove("show");
    });

    window.addEventListener("click", function(event){
        if(event.target == deleteActivityModal){
            deleteActivityModal.classList.remove("show");
        }
    });
}

const viewChallengeModal = document.getElementById("viewChallengeModal");

if(viewChallengeModal){

    const viewChallengeButtons = document.querySelectorAll(".view-btn");
    const closeViewChallengeButton = document.getElementById("closeViewChallengeBtn");
    const closeViewChallengeIcon = document.querySelector(".close-view-challenge-modal");

    viewChallengeButtons.forEach(function(button){

        button.addEventListener("click", function(){

            document.getElementById("viewChallengeId").textContent = this.dataset.id;
            document.getElementById("viewChallengeName").textContent = this.dataset.name;
            document.getElementById("viewChallengeStart").textContent = this.dataset.start;
            document.getElementById("viewChallengeEnd").textContent = this.dataset.end;
            document.getElementById("viewChallengePoints").textContent = this.dataset.points;
            document.getElementById("viewChallengeStatus").textContent = this.dataset.status;
            viewChallengeModal.classList.add("show");

        });

    });

    closeViewChallengeButton.addEventListener("click", function(){
        viewChallengeModal.classList.remove("show");
    });

    closeViewChallengeIcon.addEventListener("click", function(){
        viewChallengeModal.classList.remove("show");
    });

    window.addEventListener("click", function(event){
        if(event.target == viewChallengeModal){
            viewChallengeModal.classList.remove("show");
        }
    });
}

const addChallengeModal = document.getElementById("addChallengeModal");

if(addChallengeModal){

    const addChallengeButton = document.querySelector(".add-btn");
    const closeAddChallengeButton = document.querySelector(".close-add-challenge-modal");
    const cancelAddChallengeButton = document.getElementById("cancelAddChallenge");

    addChallengeButton.addEventListener("click", function(){
        document.getElementById("addChallengeForm").reset();
        addChallengeModal.classList.add("show");
    });

    closeAddChallengeButton.addEventListener("click", function(){
        addChallengeModal.classList.remove("show");
    });

    cancelAddChallengeButton.addEventListener("click", function(){
        addChallengeModal.classList.remove("show");
    });

    window.addEventListener("click", function(event){
        if(event.target == addChallengeModal){
            addChallengeModal.classList.remove("show");
        }
    });
}

const editChallengeModal = document.getElementById("editChallengeModal");

if(editChallengeModal){

    const editChallengeButtons = document.querySelectorAll(".edit-btn");
    const closeEditChallengeButton = document.querySelector(".close-edit-challenge-modal");
    const cancelEditChallengeButton = document.getElementById("cancelEditChallenge");

    editChallengeButtons.forEach(function(button){

        button.addEventListener("click", function(){

            document.getElementById("editChallengeId").value = this.dataset.id;
            document.getElementById("editChallengeIdDisplay").value = this.dataset.id;
            document.getElementById("editChallengeName").value = this.dataset.name;
            document.getElementById("editStartDate").value = this.dataset.start;
            document.getElementById("editEndDate").value = this.dataset.end;
            document.getElementById("editChallengePoint").value = this.dataset.points;
            document.getElementById("editChallengeStatus").value = this.dataset.status;
            editChallengeModal.classList.add("show");

        });

    });

    closeEditChallengeButton.addEventListener("click", function(){
        editChallengeModal.classList.remove("show");
    });

    cancelEditChallengeButton.addEventListener("click", function(){
        editChallengeModal.classList.remove("show");
    });

    window.addEventListener("click", function(event){
        if(event.target == editChallengeModal){
            editChallengeModal.classList.remove("show");
        }
    });
}

const deleteChallengeModal = document.getElementById("deleteChallengeModal");

if(deleteChallengeModal){

    const deleteChallengeButtons = document.querySelectorAll(".delete-btn");
    const closeDeleteButton = document.querySelector(".close-delete-challenge-modal");
    const cancelDeleteButton = document.getElementById("cancelDeleteChallenge");

    deleteChallengeButtons.forEach(function(button){

        button.addEventListener("click", function(){

            document.getElementById("deleteChallengeId").textContent = this.dataset.id;
            document.getElementById("deleteChallengeName").textContent = this.dataset.name;
            document.getElementById("deleteChallengeIdHidden").value = this.dataset.id;
            deleteChallengeModal.classList.add("show");

        });

    });

    closeDeleteButton.addEventListener("click", function(){
        deleteChallengeModal.classList.remove("show");
    });

    cancelDeleteButton.addEventListener("click", function(){
        deleteChallengeModal.classList.remove("show");
    });

    window.addEventListener("click", function(event){
        if(event.target == deleteChallengeModal){
            deleteChallengeModal.classList.remove("show");
        }
    });
}

const viewRewardModal = document.getElementById("viewRewardModal");

if(viewRewardModal){

    const viewRewardButtons = document.querySelectorAll(".view-btn");
    const closeViewRewardButton = document.getElementById("closeViewRewardBtn");
    const closeViewRewardIcon = viewRewardModal.querySelector(".close-view-reward-modal");

    viewRewardButtons.forEach(function(button){

        button.addEventListener("click", function(){

            document.getElementById("viewRewardId").textContent = this.dataset.id;
            document.getElementById("viewRewardName").textContent = this.dataset.name;
            document.getElementById("viewRewardDescription").textContent = this.dataset.description;
            document.getElementById("viewRewardPoints").textContent = this.dataset.points;
            document.getElementById("viewRewardStock").textContent = this.dataset.stock;
            document.getElementById("viewRewardStatus").textContent = this.dataset.status;
            document.getElementById("viewRewardImage").src =
                "../../uploads/rewards/" + this.dataset.image;

            viewRewardModal.classList.add("show");

        });

    });

    closeViewRewardButton.addEventListener("click", function(){
        viewRewardModal.classList.remove("show");
    });

    closeViewRewardIcon.addEventListener("click", function(){
        viewRewardModal.classList.remove("show");
    });

    window.addEventListener("click", function(event){
        if(event.target == viewRewardModal){
            viewRewardModal.classList.remove("show");
        }
    });
}

const addRewardModal = document.getElementById("addRewardModal");

if(addRewardModal){

    const addRewardButton = document.querySelector(".add-btn");
    const closeAddRewardButton = document.querySelector(".close-add-reward-modal");
    const cancelAddRewardButton = document.getElementById("cancelAddReward");

    addRewardButton.addEventListener("click", function(){
        document.getElementById("addRewardForm").reset();
        addRewardModal.classList.add("show");
    });

    closeAddRewardButton.addEventListener("click", function(){
        addRewardModal.classList.remove("show");
    });

    cancelAddRewardButton.addEventListener("click", function(){
        addRewardModal.classList.remove("show");
    });

    window.addEventListener("click", function(event){
        if(event.target == addRewardModal){
            addRewardModal.classList.remove("show");
        }
    });
}

const editRewardModal = document.getElementById("editRewardModal");

if(editRewardModal){

    const editRewardButtons = document.querySelectorAll(".edit-btn");
    const cancelEditReward = document.getElementById("cancelEditReward");
    const closeEditReward = editRewardModal.querySelector(".close-edit-reward-modal");

    editRewardButtons.forEach(function(button){

        button.addEventListener("click", function(){

            document.getElementById("editRewardId").value = this.dataset.id;
            document.getElementById("editRewardIdDisplay").value = this.dataset.id;
            document.getElementById("editRewardName").value = this.dataset.name;
            document.getElementById("editDescription").value = this.dataset.description;
            document.getElementById("editRewardPoints").value = this.dataset.points;
            document.getElementById("editRewardStock").value = this.dataset.stock;
            document.getElementById("editRewardStatus").value = this.dataset.status;

            const image = document.getElementById("editRewardImagePreview");

            if(this.dataset.image){
                image.src =
                    "../../uploads/rewards/" +
                    this.dataset.image;
                image.style.display = "block";
            }else{
                image.style.display = "none";
            }

            document.getElementById("editRewardImage").value = "";

            editRewardModal.classList.add("show");

        });

    });

    cancelEditReward.addEventListener("click", function(){
        editRewardModal.classList.remove("show");
    });

    closeEditReward.addEventListener("click", function(){
        editRewardModal.classList.remove("show");
    });

    window.addEventListener("click", function(event){
        if(event.target == editRewardModal){
            editRewardModal.classList.remove("show");
        }
    });
}

const deleteRewardModal = document.getElementById("deleteRewardModal");

if(deleteRewardModal){

    const deleteRewardButtons = document.querySelectorAll(".delete-btn");
    const closeDeleteButton = document.querySelector(".close-delete-reward-modal");
    const cancelDeleteButton = document.getElementById("cancelDeleteReward");

    deleteRewardButtons.forEach(function(button){

        button.addEventListener("click", function(){

            document.getElementById("deleteRewardId").textContent = this.dataset.id;
            document.getElementById("deleteRewardName").textContent = this.dataset.name;
            document.getElementById("deleteRewardIdHidden").value = this.dataset.id;
            deleteRewardModal.classList.add("show");

        });

    });

    closeDeleteButton.addEventListener("click", function(){
        deleteRewardModal.classList.remove("show");
    });

    cancelDeleteButton.addEventListener("click", function(){
        deleteRewardModal.classList.remove("show");
    });

    window.addEventListener("click", function(event){
        if(event.target == deleteRewardModal){
            deleteRewardModal.classList.remove("show");
        }
    });
}

const addBadgeModal = document.getElementById("addBadgeModal");

if(addBadgeModal){

    const addBadgeButton = document.querySelector(".add-btn");
    const closeAddBadgeButton = document.querySelector(".close-add-badge-modal");
    const cancelAddBadgeButton = document.getElementById("cancelAddBadge");

    addBadgeButton.addEventListener("click", function(){
        document.getElementById("addBadgeForm").reset();
        addBadgeModal.classList.add("show");
    });

    closeAddBadgeButton.addEventListener("click", function(){
        addBadgeModal.classList.remove("show");
    });

    cancelAddBadgeButton.addEventListener("click", function(){
        addBadgeModal.classList.remove("show");
    });

    window.addEventListener("click", function(event){
        if(event.target == addBadgeModal){
            addBadgeModal.classList.remove("show");
        }
    });
}

const viewBadgeModal = document.getElementById("viewBadgeModal");

if(viewBadgeModal){

    const viewButtons = document.querySelectorAll(".view-btn");
    const closeButton = document.getElementById("closeBadgeModalBtn");
    const closeIcon = viewBadgeModal.querySelector(".close-modal");

    viewButtons.forEach(function(button){

        button.addEventListener("click", function(){

            document.getElementById("viewBadgeId").textContent = this.dataset.id;
            document.getElementById("viewBadgeName").textContent = this.dataset.name;
            document.getElementById("viewDescription").textContent = this.dataset.description;
            document.getElementById("viewRequiredPoints").textContent = this.dataset.points;
            viewBadgeModal.classList.add("show");
        });
    });

    closeButton.addEventListener("click", function(){
        viewBadgeModal.classList.remove("show");
    });

    closeIcon.addEventListener("click", function(){
        viewBadgeModal.classList.remove("show");
    });

    window.addEventListener("click", function(event){
        if(event.target == viewBadgeModal){
            viewBadgeModal.classList.remove("show");
        }
    });
}

const editBadgeModal = document.getElementById("editBadgeModal");

if(editBadgeModal){

    const editButtons = document.querySelectorAll(".edit-btn");
    const closeEditBadgeButton = document.querySelector(".close-edit-badge-modal");
    const cancelEditBadgeButton = document.getElementById("cancelEditBadge");

    editButtons.forEach(function(button){

        button.addEventListener("click", function(){

            document.getElementById("editBadgeId").value = this.dataset.id;
            document.getElementById("editBadgeIdDisplay").value = this.dataset.id;
            document.getElementById("editBadgeName").value = this.dataset.name;
            document.getElementById("editDescription").value = this.dataset.description;
            document.getElementById("editRequiredPoints").value = this.dataset.points;
            editBadgeModal.classList.add("show");

        });

    });

    closeEditBadgeButton.addEventListener("click", function(){
        editBadgeModal.classList.remove("show");
    });

    cancelEditBadgeButton.addEventListener("click", function(){
        editBadgeModal.classList.remove("show");
    });

    window.addEventListener("click", function(event){
        if(event.target == editBadgeModal){
            editBadgeModal.classList.remove("show");
        }
    });
}

const deleteBadgeModal = document.getElementById("deleteBadgeModal");

if(deleteBadgeModal){

    const deleteBadgeButtons = document.querySelectorAll(".delete-btn");
    const closeDeleteButton = document.querySelector(".close-delete-badge-modal");
    const cancelDeleteButton = document.getElementById("cancelDeleteBadge");

    deleteBadgeButtons.forEach(function(button){

        button.addEventListener("click", function(){

            document.getElementById("deleteBadgeId").textContent = this.dataset.id;
            document.getElementById("deleteBadgeName").textContent = this.dataset.name;
            document.getElementById("deleteBadgeIdHidden").value = this.dataset.id;
            deleteBadgeModal.classList.add("show");

        });

    });

    closeDeleteButton.addEventListener("click", function(){
        deleteBadgeModal.classList.remove("show");
    });

    cancelDeleteButton.addEventListener("click", function(){
        deleteBadgeModal.classList.remove("show");
    });

    window.addEventListener("click", function(event){
        if(event.target == deleteBadgeModal){
            deleteBadgeModal.classList.remove("show");
        }
    });
}