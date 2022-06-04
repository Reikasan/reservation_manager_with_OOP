/* RESIZE EVENT */
/* 
    1000px - Dropdown menue
    800px  - Dropdown at .anotherReservation
    650px  - Hamburger menu for sidebar / Search-Bar shrink
*/

const sidebar = document.querySelector('.sidebar');
const hamburger = document.querySelector('.hamburger');
const nestedUl = document.querySelector('.nested');
const dropdownSign = document.querySelector('.dropdown2');
const search_row2 = document.querySelector('.row-2');
const reservationContainer = document.querySelector('.reservation-container');

function isNestedUlHidden() {
    if(nestedUl.classList.contains('hide')) {
        return true;
    } else {
        return false;
    }
}

function isHamburgerHidden() {
    if(hamburger.classList.contains('hide')) {
        return true;
    } else {
        return false;
    }
}

function isDropdownSignShown() {
    if(dropdownSign.classList.contains('show')) {
        return true;
    } else {
        return false;
    }
}

function checkWindowSize() {
    const w = window.innerWidth;
    
    const link = document.querySelector('.removalLink');
    const hasLink = link.hasAttribute('href');

    if(w <= 1000) {
        /* HIDE NESTED UL AND REMOVE LINK */
        if(!isNestedUlHidden()) {
            sidebar.classList.remove('open');
            reservationContainer.classList.add('shrink');
            nestedUl.classList.add('hide');
            nestedUl.classList.remove('no-transition');
        } 

        link.removeAttribute('href');
        dropdownMenu.classList.add('pointer');

    } else {
        /* SHOW NESTED UL AND ADD LINK*/
        if(isNestedUlHidden()) {
            reservationContainer.classList.remove('shrink');
            nestedUl.classList.remove('hide');
        } 

        if(!hasLink) {
            link.setAttribute('href', 'reservation.php');
        }
        dropdownMenu.classList.remove('pointer');
    }/* w = 1000px */

    if(dropdownSign !== null) {
        if(w <= 800) {
            /* HIDE DROPDOWN SIGN AT ANOTHER_RESERVATIONS */
            if(!isDropdownSignShown()) {
                dropdownSign.classList.add('show');
            } 
        } else {
            if(isDropdownSignShown()) {
                dropdownSign.classList.remove('show');
                dropdownSign.classList.remove('transition');
            } 
        } /* w = 800px */   
    }

    if(w <= 650) {    
        if(!isHamburgerHidden()) {
            sidebar.classList.add('hide');
            sidebar.classList.remove('transition');
            hamburger.classList.add('hide');
            hamburgerIcon.classList.remove('hide');
        }   
        if(search_row2 !== null) {
            const hideSearchbar = search_row2.classList.contains('hide');
            if(!hideSearchbar) {
                search_row2.classList.add('hide');
            }
        }
       
    } else {
        if(isHamburgerHidden()) {
            sidebar.classList.remove('hide');
            sidebar.classList.add('transition');
            hamburger.classList.remove('hide');
            hamburgerIcon.classList.add('hide');
        }

        if(search_row2 !== null) {
            const hideSearchbar = search_row2.classList.contains('hide');
            if(hideSearchbar) {
                search_row2.classList.remove('hide');
            }
        }  
    }
}

let resizeTimer;
window.addEventListener('resize', ()=> {
    if(resizeTimer != null) {
        clearTimeout(resizeTimer);
    }    
    resizeTimer = setTimeout(checkWindowSize, 200); 
});

window.addEventListener('load', checkWindowSize);

/* SIDEBAR */
/* Dropdown menue */
const dropdownMenu = document.querySelector('.dropdownMenu');

function toggleDropdown() {
    const w = window.innerWidth;
    if(w < 650) {
        if(!isNestedUlHidden()) {
            nestedUl.classList.add('hide');
            sidebar.classList.remove('transition');
            reservationContainer.classList.add('shrink');
        } else {
            nestedUl.classList.remove('hide');
            sidebar.classList.add('transition');
            reservationContainer.classList.remove('shrink');
        }
    } else if(w < 1000) {
        if(!isNestedUlHidden()) {
            nestedUl.classList.add('hide');
            sidebar.classList.remove('open');
        } else {
            nestedUl.classList.remove('hide');
            sidebar.classList.add('open');
        }
    } 
}

if(dropdownMenu !== null) {
    dropdownMenu.addEventListener('click', toggleDropdown);
}

/* Hamburger menu */
const hamburgerIcon = document.querySelector('.hamburgerIcon');
if(hamburgerIcon !== null) {
    hamburgerIcon.addEventListener('click', function() {
        if(!isHamburgerHidden()) {
            sidebar.classList.add('hide');
            sidebar.classList.remove('transition');
            hamburger.classList.add('hide');
        } else {
            sidebar.classList.remove('hide');
            sidebar.classList.add('transition');
            hamburger.classList.remove('hide');
        }
    });
}

/* SEARCH BAR */
const searchInput = document.getElementById('searchText');
if(searchInput !== null) {
    searchInput.addEventListener('input', showAllSearchBar);
    searchInput.addEventListener('blur', hideSearchBar);

    function showAllSearchBar(e) {
        const hideSearchbar = search_row2.classList.contains('hide');
        if(hideSearchbar) {
            search_row2.classList.remove('hide');
            search_row2.classList.add('transition');
        } 
    }

    function hideSearchBar(e) {
        const hideSearchbar = search_row2.classList.contains('hide');
        const searchInputValue = e.target.value;
        if(!hideSearchbar && searchInputValue === "") {
            search_row2.classList.add('hide');
            search_row2.classList.add('transition');
        } 
    }
}

// CLOSE BTN
const closeBtns = document.querySelectorAll('.closeBtn');
if(closeBtns !== null) {
    closeBtns.forEach(closeBtn => {
        closeBtn.addEventListener('click', () => {
            closeBtn.parentElement.classList.add('hide');
        });
    });    
}

// TOGGLE FLAG COLOR USING AJAX
 $(document).ready(function() {
    $('.fa-flag').each(function() {
        const flag = $(this);
        var flag_status;
        var request_id = flag.attr('data');
        const pathname = window.location.pathname;
        const path = pathname + ' i.fa-flag';

        flag.click(function() {
            if(flag.hasClass('active')) {
                $.ajax({
                    type: "POST",
                    url: "includes/ajax_code.php",
                    data: {flag_status: 'deactive', request_id: request_id},
                    success: function(response) {
                        changeFlag();
                    }
                });
            } else {
                $.ajax({
                    type: "POST",
                    url: "includes/ajax_code.php",
                    data: {flag_status: 'active', request_id: request_id},
                    success: function(response) {
                        changeFlag();
                    }
                });
            }  
        }); // flag.click
        function changeFlag() {
            $.ajax({
                type: "GET",
                url: 'includes/ajax_code.php?request_id='+request_id,
                success: function(response) {
                    if(flag.hasClass('active')) {
                        flag.removeClass('fas active');
                    }
                    flag.addClass(response);   

                }
            });
        }
    }); // $('.fa-flag').each(function()
 });


// DETAILS.PHP
// Show scroll down mark when contents is too long
const container = document.querySelector('.mail');
if(container !== null) {
    var containerHeight = container.clientHeight;
    containerHeight = containerHeight - 40;

    const contents = document.querySelector('.mail-contents');
    var contentsHeight = contents.clientHeight;
    contentsHeight = contentsHeight + 60;

    if(contentsHeight > containerHeight) {
        var downArea = document.querySelector('div.down, div.down.hide');
        downArea.classList.remove('hide');

        const downMark = document.querySelector('.down > .fa-angle-down');

        const option = { once: true };

        downMark.addEventListener('click', scrollAndHideDownmark, option);
        container.addEventListener('scroll', scrollAndHideDownmark, option);
        document.querySelector('.reservationDetails').addEventListener('scroll', scrollAndHideDownmark, option);

        function scrollAndHideDownmark() {
            container.scrollTo(0, contentsHeight);
            downArea.classList.add('hide');
        }   
    }   
}

/* Toggle Dropdown anotherReservation by click */ 
if(dropdownSign !== null) {
    dropdownSign.addEventListener('click', function() {
        const anotherReservation = document.querySelector('.anotherReservation');

        function isAnotherReservationsShown() {
            if(anotherReservation.classList.contains('open')) {
                return true;
            } else {
                return false;
            }
        }
        // const showAnotherReservations = ;
        if(isAnotherReservationsShown()) {
            anotherReservation.classList.remove('open');
            anotherReservation.classList.remove('transition');
        } else {
            anotherReservation.classList.add('open');
            anotherReservation.classList.add('transition');
        }
    });
}

const deleteBtn = document.getElementById('deleteBtn');
if(deleteBtn !== null) {
    deleteBtn.addEventListener('click', confirmDelete);
}


function confirmDelete(e) {
    const confirmText = window.confirm('Are you sure to delete this reservation?');

    if(!confirmText) {
        e.preventDefault();
    }
}

/* ADD REQUEST */
const date = document.getElementById('date')

if(date !== null){
    date.addEventListener('change', confirmPastEvent);
}

function confirmPastEvent() {
    var today = new Date();
    var dateValue = new Date(date.value);

    if(today > dateValue) {
        window.alert('Are you sure this Reservation was past Event?');
    }
}

/* SEARCHBOX.PHP */
const searchBtn = document.getElementById('searchBtn');

if(searchBtn !== null ) {
    const addFilter = document.getElementById('addFilter');
    
    // Validation with regexp
    searchBtn.addEventListener('click', function(e) {
        var searchTextValue = document.getElementById('searchText').value;
        const searchCategory = document.getElementById('searchCategory').value;

        if(searchTextValue === "" || searchCategory === "") {
            showSearchBarError("Can not search with empty input");
        } 
        
        if(searchCategory == "request_date") {
            if(!/\d+[\.\s,-]\d+/.test(searchTextValue)) {
                showSearchBarError("Invalid input. Date must be number. Ex: 06-01");   
            }

            const modifiedDate = modifyDateForSql(searchTextValue); 
            return  searchInput.value = modifiedDate;
        }
        
        if(searchCategory === "request_tel") {
            if(/[\D-]/.test(searchTextValue)) {
                showSearchBarError("Invalid input. Phone number must be number.");   
            }
            
            searchTextValue = searchTextValue.replace(/-/g, '');
            return searchInput.value = searchTextValue;
        }
        
        function showSearchBarError($errorText){
            e.preventDefault();
        
            const searchBar = document.querySelector('.search-bar');
            const errorMessageContainer = document.querySelector('.error-message');
            addFilter.style.top = "8rem";
            searchBar.style.border = "1px solid tomato";
            errorMessageContainer.style.color = "tomato";
            errorMessageContainer.innerHTML = $errorText;
            errorMessageContainer.classList.remove('.hidden')
        }

        function modifyDateForSql($searchTextValue) {
            searchTextValue = searchTextValue.replace(/[\.\s,]/g, '-');

            var dateArray = searchTextValue.split('-');
            var modifiedDateArray = Array();
 
            dateArray.forEach(date => {
                if(/^[1-9]$/.test(date)) {
                    date = date.replace(/^[1-9]$/, '0$&');
                }
                modifiedDateArray.push(date);
            });
            
            modifiedDateArray.reverse();
            return modifiedDateArray.join('-');
        }
    }, {passive: false});
    
    // drop down add filter field
    addFilter.addEventListener('click', function() {
        document.getElementById('filterForm').classList.toggle('hide');
    });

     // CHECK ONLY ONE CHECKBOX
     // flag
    const flag1 = document.getElementById('flag1');
    const flag2 = document.getElementById('flag2');
     
    flag1.addEventListener('change', function() {
        if(flag1.checked) {
            flag2.checked = false;
        }
    });
 
    flag2.addEventListener('change', function() {
        if(flag2.checked) {
            flag1.checked = false;
        }
    });

    // upcoming event
    const upcoming = document.getElementById('upcoming');
    const past = document.getElementById('past');
     
    upcoming.addEventListener('change', function() {
        if(upcoming.checked) {
            past.checked = false;
        }
    });
 
    past.addEventListener('change', function() {
        if(past.checked) {
            upcoming.checked = false;
        }
    });

    // status
    const unread = document.getElementById('unread');
    const pending = document.getElementById('pending');
    const confirmed = document.getElementById('confirmed');
    const canceled = document.getElementById('canceled');

    const statuses = [unread, pending, confirmed, canceled];

    statuses.forEach(selected => {
        selected.addEventListener('change', () => {
            if(selected === unread) {
                pending.checked = false;
                confirmed.checked = false;
                canceled.checked = false;
            } else if(selected === pending) {
                unread.checked = false;
                confirmed.checked = false;
                canceled.checked = false;
            } else if(selected === confirmed) {
                unread.checked = false;
                pending.checked = false;
                canceled.checked = false;
            } else if(selected === canceled) {
                unread.checked = false;
                pending.checked = false;
                confirmed.checked = false;
            }
        });
    });

    // clear all filters
    const clearBtn = document.getElementById('clearBtn');
    clearBtn.addEventListener('click', ()=> {
        const allFilters = document.querySelectorAll('#filterForm input[type=checkbox]');
        allFilters.forEach(filter => {
            filter.checked = false;
        });
    });
} // end of searchbox.php

/* BULKOPTION.PHP */
const bulkoptionApplyBtn = document.getElementById('bulkoptionApply');
const checkBoxes = document.querySelectorAll('.checkbox');

// bulkoptionApplyBtn.addEventListener("click", (e)=> {
//     // check checkbox status
//     var i = 0;
//     checkBoxes.forEach(checkBox => {
//         if(checkBox.checked !== true) {
//             i++;
//         }
         
//     });

//     if(i === checkBoxes.length) {
//         e.preventDefault();
//         console.log("no checkbox checked");
//     }

//     const document.getElementById('bulkoptionContainer').
//     document.createElement('div').innerHTML = 
// });
// end of bulkoption.php


// check All checkbox
const selectAllBoxes = document.getElementById('selectAllBoxes');


if(selectAllBoxes !== null) {
    selectAllBoxes.addEventListener('change', selectAllcheckBoxes);
}

function selectAllcheckBoxes() {
    checkBoxes.forEach(checkBox => {
        if(selectAllBoxes.checked) {
            checkBox.checked = true;
        } else {
            checkBox.checked = false;
        }
    });
}
    



