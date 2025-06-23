# Advanced_Books_Display


# 📚 Advanced Books Display

A custom WordPress plugin that registers a `Books` Custom Post Type with custom meta fields, filtering UI, AJAX pagination, and optional REST API support.

---

## 🔧 Features

- ✅ Registers `Books` CPT with:
  - Author Name (text)
  - Price (number)
  - Publish Date (date)
- ✅ Shortcode `[advanced_books]` to display books
- ✅ Frontend filters:
  - Author Name (starts with A–Z)
  - Price Range (50–100, 100–150, 150–200)
  - Publish Date Sort (Newest / Oldest)
- ✅ AJAX-based pagination
- ✅ REST API endpoint: `/wp-json/books/v1/list` *(optional)*
- ✅ Built with WordPress VIP Coding Standards
- ✅ Clean and minimal UI, extendable code

---

## 📁 Folder Structure

```
advanced-books-display/
│
├── includes/
│   ├── class-advanced-books-display.php
│   ├── class-books-cpt.php
│   ├── class-books-shortcode.php
│   └── class-books-rest-api.php
│
├── public/
│   ├── css/
│   │   └── advanced-books-display-public.css
│   └── js/
│       └── advanced-books-display-public.js
│
├── languages/
├── advanced-books-display.php
└── README.md
```

---

## 🚀 Installation

1. Clone or download this repository:
   ```bash
   git clone https://github.com/Vrutika28/Advanced_Books_Display.git
   ```
2. Copy the folder into your WordPress `wp-content/plugins/` directory.
3. Activate the plugin from the WordPress admin dashboard.
4. Add the shortcode `[advanced_books]` to any page or post.

---

## 💡 Usage

Add this shortcode to a page:

```
[advanced_books]
```

This will render:
- Dropdown filters (Author A–Z, Price, Sort Order)
- Book list (5 per page)
- AJAX-based pagination

---

## 🛠️ REST API (Optional)

**Endpoint:**

```
/wp-json/books/v1/list
```

**Query Parameters:**

| Param        | Description                        |
|--------------|------------------------------------|
| `author`     | Filter by starting letter (A–Z)    |
| `price_range`| Price range: `50-100`, `100-150`, `150-200` |
| `sort_by`    | `asc` or `desc` for Publish Date   |

**Example:**

```
/wp-json/books/v1/list?author=B&price_range=50-100&sort_by=asc
```

Returns an array of book objects (ID, title, author, price, publish date, link).

---

## 🔍 Screenshot (Optional)

Add `screenshot.png` to show the UI.

---

## 🤝 Contributing

Feel free to fork and send pull requests. Please follow WordPress coding standards.

---

## 👩‍💻 Author

Developed by [Vrutika Darji](https://linkedin.com/in/vrutika-darji)

---

## 📄 License

GPL-2.0-or-later — [https://www.gnu.org/licenses/gpl-2.0.txt](https://www.gnu.org/licenses/gpl-2.0.txt)


---

## 📡 REST API Details

### Endpoint
```
GET /wp-json/books/v1/list
```

### Query Parameters

| Parameter     | Type   | Description                                         |
|---------------|--------|-----------------------------------------------------|
| `author`      | string | Filter books by author name starting letter (A–Z)  |
| `price_range` | string | Price range filter. Accepts: `50-100`, `100-150`, `150-200` |
| `sort_by`     | string | Sort by publish date. Accepts: `asc` (Oldest), `desc` (Newest) |

### Example Request
```
GET /wp-json/books/v1/list?author=B&price_range=100-150&sort_by=asc
```

### Example JSON Response
```json
[
  {
    "id": 21,
    "title": "Becoming",
    "author": "B. Smith",
    "price": "120",
    "publish_date": "2024-01-15",
    "link": "https://yoursite.com/books/becoming"
  },
  {
    "id": 35,
    "title": "Building WordPress Plugins",
    "author": "Brian D.",
    "price": "140",
    "publish_date": "2023-11-10",
    "link": "https://yoursite.com/books/building-wordpress-plugins"
  }
]
```
