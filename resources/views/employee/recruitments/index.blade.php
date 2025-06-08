@extends('layouts.employee')

@section('content')
<style>
  .card-recruitment {
    transition: all 0.3s ease;
  }

  .card-recruitment:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
  }

  .card-recruitment .card-title {
    font-size: 1.1rem;
    font-weight: 600;
  }

  .card-recruitment .card-text {
    font-size: 0.9rem;
    color: #555;
  }

  /* Tùy chỉnh phân trang */
  .pagination {
    justify-content: center;
    margin-top: 20px;
  }

  .pagination .page-link {
    padding: 6px 12px;
    font-size: 0.9rem;
    border-radius: 6px;
  }

  .pagination .active .page-link {
    background-color: #0d6efd;
    color: #fff;
    border-color: #0d6efd;
  }
</style>

<div class="container mt-4">
  <h3 class="mb-4 fw-bold text-primary">
    <i class="bi bi-megaphone-fill me-2"></i> Thông báo tuyển dụng
  </h3>

  <!-- Bộ lọc -->
  <form id="filter-form" class="row row-cols-lg-auto g-2 align-items-center mb-4">
    <div class="col-12">
      <input type="text" name="keyword" class="form-control" placeholder="Từ khóa tìm kiếm..." value="{{ request('keyword') }}">
    </div>

    <div class="col-12">
      <select name="department_id" class="form-select">
        <option value="">-- Tất cả phòng ban --</option>
        @foreach ($departments as $id => $name)
          <option value="{{ $id }}" {{ request('department_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
        @endforeach
      </select>
    </div>

    <div class="col-12">
      <button type="submit" class="btn btn-primary">
        <i class="bi bi-search"></i> Lọc
      </button>
      <button type="button" id="reset-filter" class="btn btn-outline-secondary">
        <i class="bi bi-x-circle"></i> Xóa lọc
      </button>
    </div>
  </form>

  <!-- Kết quả thông báo -->
  <div id="recruitment-results">
    @include('employee.recruitments.partials.list', ['recruitments' => $recruitments])
  </div>
</div>

<!-- AJAX filter -->
<script>
  $(document).ready(function () {
    const baseUrl = "{{ route('employee.recruitments') }}";

    // Khi submit lọc
    $('#filter-form').on('submit', function (e) {
      e.preventDefault();
      fetchRecruitments();
    });

    // Khi phân trang
    $(document).on('click', '.pagination a', function (e) {
      e.preventDefault();
      let url = $(this).attr('href');
      if (url) fetchRecruitments(url);
    });

    // Reset lọc
    $('#reset-filter').on('click', function () {
      $('#filter-form')[0].reset();
     fetchRecruitments(baseUrl);
    });

    function fetchRecruitments(url = baseUrl) {
      $.ajax({
        url: url,
        type: 'GET',
        data: $('#filter-form').serialize(),
        success: function (data) {
          $('#recruitment-results').html(data);
        },
        error: function () {
          alert('Không thể tải dữ liệu. Vui lòng thử lại.');
        }
      });
    }
  });
</script>
@endsection
