@props(['message' => 'Bạn có chắc chắn muốn thực hiện thao tác này?'])

<script>
    function confirmDelete() {
        return confirm(@json($message));
    }
</script>