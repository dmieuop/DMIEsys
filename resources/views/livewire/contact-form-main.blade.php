<div>
    <?php
                    if (!empty($_SERVER['HTTP_CLIENT_IP'])) $ip = $_SERVER['HTTP_CLIENT_IP'];
                    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                    else $ip = $_SERVER['REMOTE_ADDR'];
                    $ip = md5($ip)
    ?>
    <form wire:submit.prevent="formSubmit('{{ $ip }}')" method="post">
        <div class="row pt-3 px-5">
            @csrf @honeypot
            <div class="col-md-4">
                <p class="text-light fs-4">Have something to ask?</p>
                <p class="text-secondary">Please filled out the quick form and leave us a message. We will get back to
                    you as soon as possible.</p>
                <button class="btn rounded-full btn-sm btn-outline-success float-start" type="submit">Send a
                    Message</button>
                @if ($is_success)
                <button class="btn rounded-full ms-2 btn-sm bg-green-400 float-start disabled" type="button">
                    <i class="bi bi-check2-circle"></i> Message sent
                </button>
                @endif
                @if ($is_failed)
                <button class="btn rounded-full ms-2 btn-sm btn-danger float-start disabled" type="button">
                    <i class="bi bi-exclamation-circle"></i> {{ $errormsg }}
                </button>
                @endif
            </div>
            <div class="col-md-3 mt-3">
                <div class="mb-3">
                    <input type="text" class="form-control bg-dark text-light form-control-sm" wire:model="name"
                        placeholder="What is your name?" maxlength="50" name="name" required>
                </div>
                <div class="mb-3">
                    <input type="email" class="form-control bg-dark text-light form-control-sm" wire:model="email"
                        placeholder="What is your email?" maxlength="100" name="email" required>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control bg-dark text-light form-control-sm" wire:model="phone"
                        placeholder="What is your contact number?" maxlength="15" name="phone" required>
                </div>
            </div>
            <div class="col-md-5 mt-3">
                <div class="mb-2">
                    <textarea class="form-control form-control-sm bg-dark text-light"
                        placeholder="What is your message?" style="height: 124px" wire:model="message"
                        required></textarea>
                </div>
            </div>
        </div>
    </form>
</div>
