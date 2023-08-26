@extends('layouts.app', ['title' => __('Chat')])
@section('main-content')
    <div class="row">
        @if (session()->has('error'))
            <div class="alert alert-danger flash-message"
                style="position: fixed; top: 40px; z-index: 999; left: 50%; transform: translate(-50%, -50%)">
                {{ session('error') }}
            </div>
        @elseif(session()->has('success'))
            <div class="alert alert-success flash-message"
                style="position: fixed; top: 40px; z-index: 999; left: 50%; transform: translate(-50%, -50%)">
                {{ session('success') }}
            </div>
        @endif
        <div class="col-12">
            <div class="chat-box-left">
                <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link tab-link" id="group_chat_tab" data-toggle="pill" href="#group_chat">Groups</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link tab-link active" id="personal_chat_tab" data-toggle="pill"
                            href="#personal_chat">Personal</a>
                    </li>
                </ul>
                <div class="chat-search">
                    <div class="form-group">
                        <form name="search-user" id="search-user" action="POST" action="#">
                            <div class="input-group">
                                <input type="text" id="chat-search" name="chat-search" class="form-control"
                                    placeholder="Search">
                                <span class="input-group-append">
                                    <button id="chat-search-button" type="button"
                                        class="btn btn-gradient-primary shadow-none"><i class="fas fa-search"></i></button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div><!--end chat-search-->

                <div class="tab-content chat-list slimscroll" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="personal_chat">
                        @forelse($contacts as $contact)
                            @php
                                $url = '../assets/images/users/user-1.jpg';
                                if ($contact->photo) {
                                    $url = 'https://dev.mycryptopoolmirror.com/media/profileImages/' . $contact->photo;
                                }
                            @endphp
                            <a data-name="{{ $contact->username }}" data-photo="{{ $url }}"
                                data-id="{{ $contact->id }}" style="cursor: pointer;" class="media site-user">
                                <div class="media-left">
                                    <img src="{{ $url }}" alt="user" class="rounded-circle thumb-md">
                                    <span class="round-10 bg-success"></span>
                                </div><!-- media-left -->
                                <div class="media-body">
                                    <div class="d-inline-block">
                                        <h6>{{ $contact->username }}</h6>
                                        <p>Good morning! Congratulations Friend...</p>
                                    </div>
                                    <div>
                                        <span>20 Feb</span>
                                        <span>3</span>
                                    </div>
                                </div><!-- end media-body -->
                            </a> <!--end media-->
                        @empty
                            <div class="alert alert-info">
                                No user found in your contact list!
                            </div>
                        @endforelse
                    </div><!--end general chat-->

                    <div class="tab-pane fade" id="group_chat">
                        <input type="button" class="btn btn-primary btn-block" value="create">
                        @foreach ($group as $groups)
                            <a href="" class="media new-message">
                                <div class="media-left">
                                    <div class="avatar-box thumb-md align-self-center mr-2">
                                        <span class="avatar-title bg-primary rounded-circle"><i
                                                class="fab fa-quinscape"></i></span>
                                    </div>
                                </div><!-- media-left -->
                                <div class="media-body">
                                    <div>
                                        <h6>{{ $groups['group_name'] }}</h6>
                                        <p>{{ $groups['last_message'] }}</p>
                                    </div>
                                    <div>
                                        <span>20 Feb</span>
                                        <span>1</span>
                                    </div>
                                </div><!-- end media-body -->
                            </a> <!--end media-->
                        @endforeach
                    </div><!--end group chat-->

                    <div class="tab-pane fade" id="personal_chat">
                        <a href="" class="media new-message">
                            <div class="media-left">
                                <img src="../assets/images/users/user-1.jpg" alt="user" class="rounded-circle thumb-md">
                                <span class="round-10 bg-success"></span>
                            </div><!-- media-left -->
                            <div class="media-body">
                                <div class="d-inline-block">
                                    <h6>Daniel Madsen</h6>
                                    <p>Good morning! Congratulations Friend...</p>
                                </div>
                                <div>
                                    <span>20 Feb</span>
                                    <span>3</span>
                                </div>
                            </div><!-- end media-body -->
                        </a><!--end media-->
                        <a href="" class="media new-message">
                            <div class="media-left">
                                <img src="../assets/images/users/user-2.jpg" alt="user" class="rounded-circle thumb-md">
                                <span class="round-10 bg-success"></span>
                            </div><!-- media-left -->
                            <div class="media-body">
                                <div>
                                    <h6>Robert Jefferson</h6>
                                    <p>Congratulations Friend...</p>
                                </div>
                                <div>
                                    <span>20 Feb</span>
                                    <span>1</span>
                                </div>
                            </div><!-- end media-body -->
                        </a><!--end media-->
                        <a href="" class="media">
                            <div class="media-left">
                                <img src="../assets/images/users/user-3.jpg" alt="user" class="rounded-circle thumb-md">
                                <span class="round-10 bg-danger"></span>
                            </div><!-- media-left -->
                            <div class="media-body">
                                <div>
                                    <h6>Jesse Ross</h6>
                                    <p>How are you Friend...</p>
                                </div>
                                <div>
                                    <span>15 Feb</span>
                                </div>
                            </div><!-- end media-body -->
                        </a><!--end media-->
                        <a href="" class="media">
                            <div class="media-left">
                                <img src="../assets/images/users/user-4.jpg" alt="user" class="rounded-circle thumb-md">
                                <span class="round-10 bg-danger"></span>
                            </div><!-- media-left -->
                            <div class="media-body">
                                <div>
                                    <h6>Mary Schneider</h6>
                                    <p>Have A Nice day...</p>
                                </div>
                                <div>
                                    <span>14 Feb</span>
                                </div>
                            </div><!-- end media-body -->
                        </a><!--end media-->
                        <a href="" class="media">
                            <div class="media-left">
                                <img src="../assets/images/users/user-5.jpg" alt="user"
                                    class="rounded-circle thumb-md">
                                <span class="round-10 bg-success"></span>
                            </div><!-- media-left -->
                            <div class="media-body">
                                <div>
                                    <h6>David Herrmann</h6>
                                    <p>Good morning! How are you?</p>
                                </div>
                                <div>
                                    <span>10 Feb</span>
                                </div>
                            </div><!-- end media-body -->
                        </a><!--end media-->
                        <a href="" class="media">
                            <div class="media-left">
                                <img src="../assets/images/users/user-6.jpg" alt="user"
                                    class="rounded-circle thumb-md">
                                <span class="round-10 bg-danger"></span>
                            </div><!-- media-left -->
                            <div class="media-body">
                                <div>
                                    <h6>Mary Hayes</h6>
                                    <p>How are you Friend...</p>
                                </div>
                                <div>
                                    <span>1 Feb</span>
                                </div>
                            </div><!-- end media-body -->
                        </a><!--end media-->
                        <a href="" class="media">
                            <div class="media-left">
                                <img src="../assets/images/users/user-7.jpg" alt="user"
                                    class="rounded-circle thumb-md">
                                <span class="round-10 bg-danger"></span>
                            </div><!-- media-left -->
                            <div class="media-body">
                                <div>
                                    <h6>Rita Duarte</h6>
                                    <p>Have A Nice day...</p>
                                </div>
                                <div>
                                    <span>30 Jan</span>
                                </div>
                            </div><!-- end media-body -->
                        </a><!--end media-->
                        <a href="" class="media">
                            <div class="media-left">
                                <img src="../assets/images/users/user-8.jpg" alt="user"
                                    class="rounded-circle thumb-md">
                                <span class="round-10 bg-danger"></span>
                            </div><!-- media-left -->
                            <div class="media-body">
                                <div>
                                    <h6>Dennis Wilson</h6>
                                    <p>Good morning! How are you?</p>
                                </div>
                                <div>
                                    <span>26 Jan</span>
                                </div>
                            </div><!-- end media-body -->
                        </a><!--end media-body-->
                    </div><!--end personal chat-->
                </div><!--end tab-content-->
            </div><!--end chat-box-left -->

            <div class="chat-box-right">
                <div class="chat-header">
                    <a href="" class="media">
                        <div class="media-left">
                            <input type="hidden" id="reciever_id" value="" />
                            <img id="talking-to-img" src="../assets/images/users/user-4.jpg" alt="user"
                                class="rounded-circle thumb-md">
                        </div><!-- media-left -->
                        <div class="media-body">
                            <div>
                                <h6 class="mb-1 mt-0" id="talking-to">Mary Schneider</h6>
                                <p class="mb-0">Last seen: 2 hours ago</p>
                            </div>
                        </div><!-- end media-body -->
                    </a><!--end media-->
                    <div class="chat-features">
                        <div class="d-none d-sm-inline-block">
                            <a href=""><i class="fas fa-phone"></i></a>
                            <a href=""><i class="fas fa-video"></i></a>
                            <a href=""><i class="fas fa-trash-alt"></i></a>
                            <a href=""><i class="fas fa-ellipsis-v"></i></a>
                        </div>
                    </div><!-- end chat-features -->
                </div><!-- end chat-header -->
                <div class="chat-body ">
                    <div class="chat-detail slimscroll">
                        <div class="media">
                            <div class="media-img">
                                <img src="../assets/images/users/user-4.jpg" alt="user"
                                    class="rounded-circle thumb-md">
                            </div>
                            <div class="media-body">
                                <div class="chat-msg">
                                    <p>Good Morning !</p>
                                </div>
                                <div class="chat-msg">
                                    <p>There are many variations of passages of Lorem Ipsum available.</p>
                                </div>
                            </div><!--end media-body-->
                        </div><!--end media-->

                        <div class="media">
                            <div class="media-body reverse">
                                <div class="chat-msg">
                                    <p>Good Morning !</p>
                                </div>
                                <div class="chat-msg">
                                    <p>There are many variations of passages of Lorem Ipsum available.</p>
                                </div>
                            </div><!--end media-body-->
                            <div class="media-img">
                                <img src="../assets/images/users/user-3.jpg" alt="user"
                                    class="rounded-circle thumb-md">
                            </div>
                        </div><!--end media-->

                        <div class="media">
                            <div class="media-img">
                                <img src="../assets/images/users/user-4.jpg" alt="user"
                                    class="rounded-circle thumb-md">
                            </div>
                            <div class="media-body">
                                <div class="chat-msg">
                                    <p>There are many variations of passages of Lorem Ipsum available.</p>
                                </div>
                            </div><!--end media-body-->
                        </div><!--end media-->

                        <div class="media">
                            <div class="media-body reverse">
                                <div class="chat-msg">
                                    <p>Good Morning !</p>
                                </div>
                                <div class="chat-msg">
                                    <p>It is a long established fact that a reader will be distracted by
                                        the readable content of a page when looking at its layout.
                                        The point of using Lorem Ipsum is that it has a more-or-less normal
                                        distribution of letters, as opposed to using 'Content here.
                                    </p>
                                </div>
                            </div><!--end media-body-->
                            <div class="media-img">
                                <img src="../assets/images/users/user-3.jpg" alt="user"
                                    class="rounded-circle thumb-md">
                            </div>
                        </div><!--end media-->

                        <div class="media">
                            <div class="media-img">
                                <img src="../assets/images/users/user-4.jpg" alt="user"
                                    class="rounded-circle thumb-md">
                            </div>
                            <div class="media-body">
                                <div class="chat-msg">
                                    <p>Good Morning !</p>
                                </div>
                                <div class="chat-msg">
                                    <p>It is a long established fact that a reader will be distracted by
                                        the readable content of a page when looking at its layout.
                                        The point of using Lorem Ipsum is that it has a more-or-less normal
                                        distribution of letters, as opposed to using 'Content here.
                                    </p>
                                </div>
                                <div class="chat-msg">
                                    <p>Ok</p>
                                </div>
                            </div><!--end media-body-->
                        </div> <!--end media-->

                        <div class="media">
                            <div class="media-body reverse">
                                <div class="chat-msg">
                                    <p>Good Morning !</p>
                                </div>
                                <div class="chat-msg">
                                    <p>There are many variations of passages of Lorem Ipsum available.</p>
                                </div>
                            </div><!--end media-body-->
                            <div class="media-img">
                                <img src="../assets/images/users/user-3.jpg" alt="user"
                                    class="rounded-circle thumb-md">
                            </div>
                        </div> <!--end media-->
                    </div> <!-- end chat-detail -->
                </div><!-- end chat-body -->
                <div class="chat-footer">
                    <div class="row">
                        <div class="col-12 col-md-9">
                            <span class="chat-admin"><img src="../assets/images/users/user-3.jpg" alt="user"
                                    class="rounded-circle thumb-sm"></span>
                            <form method="POST" name="sendMessage" id="sendMessage">
                                @csrf
                                <input type="text" class="form-control" placeholder="Type something here...">
                            </form>
                        </div><!-- col-8 -->
                        <div class="col-3 text-right">
                            <div class="d-none d-sm-inline-block chat-features">
                                <a href=""><i class="fas fa-camera"></i></a>
                                <a href=""><i class="fas fa-paperclip"></i></a>
                                <a href=""><i class="fas fa-microphone"></i></a>
                            </div>
                        </div><!-- end col -->
                    </div><!-- end row -->
                </div><!-- end chat-footer -->
            </div><!--end chat-box-right -->
        </div> <!-- end col -->
    </div>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js"
    integrity="sha512-uMtXmF28A2Ab/JJO2t/vYhlaa/3ahUOgj1Zf27M5rOo8/+fcTUVH0/E0ll68njmjrLqOBjXM3V9NiPFL5ywWPQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        const form = document.getElementById("sendMessage");
        form.addEventListener("submit", function(e) {
            e.preventDefault();
            const reciever = document.getElementById("reciever_id");
            
            $.ajax({
                url: "/api/sendMessage",
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    sender_id: "{{ auth()->user()->id }}",
                    reciever_id: reciever.value,
                    message: "Dummy Message"
                }
            }).done(function(res) {
                console.log(res);
            })
        });
    </script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        const users = document.querySelectorAll(".site-user");
        console.log(users);
        users.forEach(user => {
            user.addEventListener("mouseover", () => {
                user.classList.add("new-message");
            });
            user.addEventListener("mouseout", () => {
                user.classList.remove("new-message");
            })
            user.addEventListener("click", () => {
                const username = user.dataset.name;
                const photo = user.dataset.photo;
                const id = user.dataset.id;

                const talkingTo = document.getElementById("talking-to");
                const img = document.getElementById("talking-to-img");
                const reciever_id = document.getElementById("reciever_id");
                
                const ids = ["{{ auth()->user()->id }}", id];
                console.log(ids);
                Pusher.logToConsole = true;
                let pusher = new Pusher('4df466d966a05206294a', {
                    cluster: 'ap2',
                    encrypted: true
                });
                let channel = pusher.subscribe(`channel-${ Math.min(...ids) }-${ Math.max(...ids) }`);


                channel.bind('sendMessage', function(data) {
                    console.log(data);
                });
                
                talkingTo.innerHTML = username;
                img.src = photo;
                reciever_id.value = id;
            })
        });
    </script>
    <script>
        const getTemplate = (username, src) => {
            let url = "../assets/images/users/user-1.jpg";
            if (src) {
                url = `https://dev.mycryptopoolmirror.com/media/profileImages/${src}`;
            }
            return `
                    <span class="media new-message">
                        <div class="media-left">
                            <img src="${url}" alt="user" class="rounded-circle thumb-md">
                            <span class="round-10 bg-success"></span>
                        </div><!-- media-left -->
                        <div class="media-body">
                            <div class="d-inline-block">
                                <h6>${username}</h6>
                                <p>Good morning! Congratulations Friend...</p>
                            </div>
                            <div>
                                <span>20 Feb</span>
                                <span>3</span>
                                <form method="POST" data-username="${username}" name="addToContact" onsubmit="addToContact(event)" class="addToContact" action="/addContact/${username}" style="display: inline-block;">
                                    @csrf
                                    <input type="hidden" name="contact_id" value="${username}" />
                                    <button class="add-to-contact" style="width: 70px; height: 30px; padding: 0px; margin-top: 20px; border-radius: 30px;" class="btn btn-gradient-primary shadow-none">Add</button>
                                </form>
                            </div>

                        </div><!-- end media-body -->
                    </span> <!--end media--> 
        `
        }
        const searchForm = document.getElementById("search-user");
        searchForm.addEventListener("submit", e => {
            e.preventDefault();

            const chatSearch = document.getElementById("chat-search");
            const username = chatSearch.value;
            const personalChat = document.getElementById("personal_chat");
            const renderData = (url) => {
                axios.get(url)
                    .then(res => {
                        const users = res.data;

                        personalChat.innerHTML = "";
                        users.forEach(user => {
                            const {
                                username,
                                photo
                            } = user;
                            personalChat.innerHTML += getTemplate(username, photo);
                        });
                        const addContact = username => {
                            axios.post(`/addContact/${username}`)
                                .then(res => {
                                    console.log(res);
                                })
                                .catch(err => {
                                    console.log(err);
                                })
                        }
                    })
                    .catch(err => {
                        console.log(err)
                    });
            }
            renderData(`/api/user/${username}`);

        })
        const flash_message = document.querySelector(".flash-message");
        if (flash_message) {
            setTimeout(() => {
                flash_message.style.display = "none"
            }, 5000);
        }


        $('.tab-link').on('click', function(e) {
            e.preventDefault();

            $('.tab-link').removeClass('active');
            $(this).addClass('active');

            var target = $(this).attr('href');
            $('.tab-pane').fadeOut(0, function() {
                $(this).removeClass('show active');
                $(target).fadeIn(0).addClass('show active');
            });

            // Chat logs ko bhi fade effect ke saath dikhayein
            // $('.chat-detail').fadeOut(300, function() {
            //     $(this).empty().append($(target + ' .chat-detail').html()).fadeIn(300);
            // });
        });
    </script>
@endpush
@yield('script')
