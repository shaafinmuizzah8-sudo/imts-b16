<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Directory</title>
    <style>
        /* Basic page design */
        :root {
            color-scheme: light;
            font-family: Inter, Arial, sans-serif;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 32px 16px;
            background: #f4f7fb;
            color: #172033;
        }

        .page {
            max-width: 1100px;
            margin: 0 auto;
        }

        .header,
        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
        }

        .header {
            margin-bottom: 22px;
        }

        h1 {
            margin: 0;
            font-size: 28px;
        }

        .subtitle {
            margin: 6px 0 0;
            color: #68758a;
            font-size: 14px;
        }

        .card {
            background: #fff;
            border: 1px solid #e4eaf2;
            border-radius: 14px;
            overflow: hidden;
        }

        .toolbar {
            padding: 18px 20px;
            border-bottom: 1px solid #edf1f6;
        }

        .search {
            display: flex;
            flex: 1;
            max-width: 480px;
            gap: 8px;
        }

        input,
        button,
        .button {
            border: 0;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 14px;
        }

        input {
            width: 100%;
            border: 1px solid #d5deea;
        }

        button,
        .button {
            background: #356dcc;
            color: #fff;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            padding: 14px 18px;
            background: #f8fafc;
            color: #657389;
            font-size: 12px;
            text-align: left;
        }

        td {
            padding: 15px 18px;
            border-top: 1px solid #edf1f6;
            font-size: 14px;
        }

        .actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .edit-link {
            padding: 7px 11px;
            border: 1px solid #c9d9f5;
            border-radius: 8px;
            background: #eef4ff;
            color: #285bb0;
            text-decoration: none;
            font-weight: 600;
        }

        .delete-button {
            padding: 7px 10px;
            background: #fff0f0;
            color: #c43d3d;
        }

        .empty {
            text-align: center;
            color: #68758a;
            padding: 32px 18px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 6px;
            padding: 18px;
            border-top: 1px solid #edf1f6;
        }

        .pagination button {
            background: #f1f5fc;
            color: #356dcc;
        }

        .pagination button.active,
        .pagination button:hover {
            background: #356dcc;
            color: #fff;
        }

        @media (max-width: 650px) {
            body {
                padding: 20px 10px;
            }

            .header,
            .toolbar {
                align-items: stretch;
                flex-direction: column;
            }

            .search {
                max-width: none;
            }
        }
    </style>
</head>

<body>
    <main class="page">
        <header class="header">
            <div>
                <h1>User Directory</h1>
                <p class="subtitle">Manage registered users and their account details.</p>
            </div>
        </header>

        <section class="card">
            <div class="toolbar">
                <!-- JavaScript sends this value to search.php -->
                <form class="search" id="searchForm">
                    <input type="search" name="search" id="search" placeholder="Search users">
                    <!-- <button type="submit">Search</button> -->
                </form>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Registration Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <!-- Search results are added here by JavaScript -->
                    <tbody id="userRows">
                        <tr>
                            <td class="empty" colspan="6">Loading users...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Page buttons are added here by JavaScript -->
            <div class="pagination" id="pagination"></div>
        </section>
    </main>

    <script>
        // Get the form, input box, and table body from the page.
        const form = document.getElementById('searchForm');
        const input = document.getElementById('search');
        const rows = document.getElementById('userRows');
        const pagination = document.getElementById('pagination');
        let searchTimer;

        function loadUsers(page = 1) {
            // Send the search text and page number to search.php.
            const params = new URLSearchParams({
                search: input.value,
                page: page
            });

            fetch(`search.php?${params}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Search request failed');
                    }
                    return response.json();
                })
                // Put the rows and page buttons into the page.
                .then(result => {
                    rows.innerHTML = result.rows;
                    pagination.innerHTML = result.pagination;
                })
                .catch(() => {
                    rows.innerHTML = '<tr><td class="empty" colspan="6">Unable to load users.</td></tr>';
                    pagination.innerHTML = '';
                });
        }

        // Search when the user clicks the Search button.
        form.addEventListener('submit', event => {
            event.preventDefault();
            loadUsers();
        });

        // Search while the user is typing.
        input.addEventListener('input', () => {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => loadUsers(1), 150);
        });

        // Load a different page when a page button is clicked.
        pagination.addEventListener('click', event => {
            if (event.target.tagName === 'BUTTON') {
                loadUsers(event.target.dataset.page);
            }
        });

        // Load all users when the page first opens.
        loadUsers();
    </script>
</body>

</html>