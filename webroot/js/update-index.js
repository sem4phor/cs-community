var conn;
conn = new ab.Session('ws://localhost:8080',
    function () {
        conn.subscribe('new_chat_message', function(topic, data) {
            // This is where you would add the new article to the DOM (beyond the scope of this tutorial)
            console.log('New chat message received');
            console.log(data);
        });
        conn.subscribe('new_lobby', function (topic, data) {
            // This is where you would add the new article to the DOM (beyond the scope of this tutorial)
            console.log('New lobby received');
            console.log(data);
            // check if lobby should be displayed with user comparing lobby data

            var lobby_item = document.createElement("div");
            lobby_item.setAttribute("class", "lobby-item row");

            var lang_col = document.createElement("div");
            lang_col.setAttribute("class", "column medium-1");
            var lang_img = document.createElement("img");
            lang_img.setAttribute("src", "flags/" + data.language + ".png");
            lang_img.setAttribute("alt", data.language);
            lang_col.appendChild(lang_img);
            lobby_item.appendChild(lang_col);

            var user_col = document.createElement("div");
            user_col.setAttribute("class", "column medium-2");
            var user_avatar_row = document.createElement("div");
            user_avatar_row.setAttribute("class", "row");
            var user_avatar = document.createElement("img");
            user_avatar.setAttribute("src", data.owner_id.avatar);
            user_avatar.setAttribute("alt", "steam avatar");
            user_avatar.setAttribute("heigth", "20");
            user_avatar.setAttribute("width", "20");
            user_avatar.setAttribute("url", data.owner_id.profileurl);
            user_avatar.setAttribute("class", "lobby_owner");
            user_avatar_row.appendChild(user_avatar);
            user_col.appendChild(user_avatar_row);
            var user_flag_row = document.createElement("div");
            user_flag_row.setAttribute("class", "row");
            var user_flag = document.createElement("img");
            user_flag.setAttribute("src", "/cs-community/img/flags/" + data.owner_id.country_code + ".png");
            user_flag.setAttribute("alt", data.owner_id.country_code);
            user_flag.setAttribute("heigth", "20");
            user_flag.setAttribute("width", "20");
            user_flag_row.appendChild(user_flag);
            user_col.appendChild(user_flag_row);
            lobby_item.appendChild(user_col);

            var rank_col = document.createElement("div");
            rank_col.setAttribute("class", "column medium-4");
            var rank_from = document.createElement("img");
            rank_from.setAttribute("src", "/cs-community/img/ranks/" + data.rank_from + ".png");
            rank_from.setAttribute("alt", data.rank_from);
            var rank_to = document.createElement("img");
            rank_to.setAttribute("src", "/cs-community/img/ranks/" + data.rank_to + ".png");
            rank_to.setAttribute("alt", data.rank_to);
            rank_col.appendChild(rank_from);
            rank_col.appendChild(rank_to);
            lobby_item.appendChild(rank_col);


            var mic_prime_col = document.createElement("div");
            mic_prime_col.setAttribute("class", "column medium-1");
            var mic_row = document.createElement("div");
            mic_row.setAttribute("class", "row");
            var mic_icon = document.createElement("img");
            mic_icon.setAttribute("src", "/cs-community/img/microphone.png");
            mic_icon.setAttribute("alt", "microphone");
            mic_icon.setAttribute("heigth", "20");
            mic_icon.setAttribute("width", "20");
            if (data.microphone_req == 1) {
                mic_icon.after(document.createTextNode("Yes"));
            } else {
                mic_icon.after(document.createTextNode("No"));
            }
            mic_row.appendChild(mic_icon);
            mic_prime_col.appendChild(mic_row);
            var prime_row = document.createElement("div");
            prime_row.setAttribute("class", "row");
            var prime_icon = document.createElement("img");
            prime_icon.setAttribute("src", "/cs-community/img/prime.png");
            prime_icon.setAttribute("alt", "prime");
            prime_icon.setAttribute("heigth", "20");
            prime_icon.setAttribute("width", "20");
            if (data.prime_req == 1) {
                prime_icon.after("__('Yes')");
            } else {
                prime_icon.after("<?= __('No') ?>");
            }
            prime_row.appendChild(prime_icon);
            mic_prime_col.appendChild(prime_row);
            lobby_item.appendChild(mic_prime_col);

            var created_col = document.createElement("div");
            created_col.setAttribute("class", "column medium-1");
            created_col.innerHTML = "Just now";
            lobby_item.appendChild(created_col);

            var action_col = document.createElement("div");
            action_col.setAttribute("class", "column medium-2");
            var join_button = document.createElement("a");
            join_button.setAttribute("href", "/lobbies/join/" + data.lobby_id);
            join_button.setAttribute("class", "button");
            join_button.innerHTML = "<?= __('Join') ?>";
            action_col.appendChild(join_button);
            lobby_item.appendChild(action_col);

            document.getElementById('lobbies-list').prepend(lobby_item);


        });
    },
    function () {
        console.warn('WebSocket connection closed');
    },
    {'skipSubprotocolCheck': true}
);