<div class="ms-{{ $level ?? 0 }} mb-3">

  <div class="rounded border p-2">

    <strong>{{ $comment->user->name }}</strong>

    <p class="mb-1">{{ $comment->comment }}</p>

    <small class="text-muted">
      {{ $comment->created_at->diffForHumans() }}
    </small>

    @auth
      @if ($course->is_enrolled)
        <a href="javascript:void(0)" onclick="toggleReply({{ $comment->id }})" class="text-primary small ms-2">
          Reply
        </a>
      @endif
    @endauth

  </div>

  {{-- Reply Form --}}
  <div id="reply-box-{{ $comment->id }}" class="d-none ms-4 mt-2">

    <form action="{{ route('student.course.comment', $course->id) }}" method="POST">
      @csrf

      <textarea name="comment" class="form-control mb-2" placeholder="Write reply..." required></textarea>

      <input type="hidden" name="parent_id" value="{{ $comment->id }}">

      <button class="btn btn-sm btn-primary">
        Reply
      </button>
    </form>

  </div>

  {{-- Replies (Recursive) --}}
  @foreach ($comment->replies as $reply)
    @include('home.courses.partials.course-comment', [
        'comment' => $reply,
        'level' => ($level ?? 0) + 4,
    ])
  @endforeach

</div>
