# Wood Trading Application

A comprehensive Laravel-based wood trading management system with multi-tenant support, inventory management, sales, purchases, and financial operations.

## Features

### Core Modules
- **Inventory Management**: Item catalog, stock tracking, lot management, low stock alerts
- **Purchase Management**: Purchase orders, goods receipt, supplier management
- **Sales Management**: Quotations, sales orders, delivery notes, invoicing
- **Customer & Supplier CRM**: Contact management, credit limits, payment terms
- **Financial Operations**: Payment tracking, aging reports, financial summaries
- **Reporting & Analytics**: Stock valuation, sales/purchase reports, performance dashboards

### Technical Features
- **Multi-tenant Architecture**: Support for multiple companies/tenants
- **Role-based Access Control**: Granular permissions for different user roles
- **RESTful API**: Complete API with Swagger documentation
- **Real-time Stock Tracking**: FIFO/Average costing methods
- **Audit Logging**: Complete activity tracking
- **PDF Generation**: Invoices and reports
- **Comprehensive Testing**: Unit and feature tests

## Technology Stack

- **Backend**: Laravel 8.x
- **Database**: MySQL/PostgreSQL
- **Authentication**: Laravel Sanctum
- **Authorization**: Spatie Laravel Permission
- **API Documentation**: Swagger/OpenAPI
- **Testing**: PHPUnit
- **PDF Generation**: DomPDF
- **Multi-tenancy**: Spatie Laravel Multitenancy

## Installation

### Prerequisites
- PHP 7.3 or higher
- Composer
- MySQL 5.7+ or PostgreSQL 10+
- Node.js and NPM (for frontend assets)

### Step 1: Clone the Repository
```bash
git clone https://github.com/your-username/wood-trading.git
cd wood-trading
```

### Step 2: Install Dependencies
```bash
composer install
npm install
```

### Step 3: Environment Configuration
```bash
cp .env.example .env
php artisan key:generate
```

Update your `.env` file with database credentials and other settings:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=wood_trading
DB_USERNAME=your_username
DB_PASSWORD=your_password

SANCTUM_STATEFUL_DOMAINS=localhost,127.0.0.1
```

### Step 4: Database Setup
```bash
php artisan migrate
php artisan db:seed
```

### Step 5: Generate API Documentation
```bash
php artisan l5-swagger:generate
```

### Step 6: Start the Application
```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

## API Documentation

Once the application is running, you can access the interactive API documentation at:
- **Swagger UI**: `http://localhost:8000/api/documentation`

## Default Users

After running the seeders, you'll have the following default users:

| Role | Email | Password |
|------|-------|----------|
| Owner/Admin | admin@woodtrading.com | password |
| Salesperson | sarah@woodtrading.com | password |
| Storekeeper | mike@woodtrading.com | password |
| Accountant | lisa@woodtrading.com | password |

## User Roles and Permissions

### Owner/Admin
- Full access to all modules
- User and role management
- System configuration
- All reports and analytics

### Salesperson
- Create and manage quotations
- Create and manage sales orders
- View stock levels
- Generate invoices
- Manage customers
- View sales reports

### Storekeeper
- Receive purchase orders
- Issue delivery notes
- Stock adjustments
- Warehouse management
- View stock reports

### Accountant
- Record payments
- View financial reports
- Manage aging reports
- Tax management
- View all financial data

## API Usage

### Authentication
```bash
# Login
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@woodtrading.com","password":"password"}'

# Use token in subsequent requests
curl -X GET http://localhost:8000/api/items \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### Example API Calls

#### Get Items
```bash
curl -X GET "http://localhost:8000/api/items?search=pine&page=1&per_page=10" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

#### Create Item
```bash
curl -X POST http://localhost:8000/api/items \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "code": "PINE-2X4-8",
    "name": "Pine 2x4 8ft",
    "species": "Pine",
    "grade": "A",
    "thickness": 38.1,
    "width": 88.9,
    "length": 2438.4,
    "unit": "piece",
    "costing_method": "FIFO"
  }'
```

#### Adjust Stock
```bash
curl -X POST http://localhost:8000/api/stock/adjust \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "item_id": 1,
    "warehouse_id": 1,
    "quantity": 10,
    "type": "adjustment",
    "movement": "in",
    "reason": "Physical count adjustment"
  }'
```

## Testing

### Run Tests
```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit

# Run with coverage
php artisan test --coverage
```

### Test Database
The tests use a separate in-memory SQLite database. No additional setup is required.

## Database Schema

### Core Entities
- **Items**: Wood products with specifications
- **StockLots**: Inventory batches with quantities and costs
- **Warehouses**: Storage locations
- **Customers**: Client information and credit limits
- **Suppliers**: Vendor information and terms
- **PurchaseOrders**: Purchase requests and confirmations
- **SalesOrders**: Customer orders
- **Invoices**: Billing documents
- **Payments**: Financial transactions
- **StockMovements**: Inventory tracking

### Key Relationships
- Items have multiple StockLots
- StockLots belong to Warehouses
- PurchaseOrders have multiple Items
- SalesOrders have multiple Items
- Invoices are generated from SalesOrders
- Payments are linked to Invoices

## Configuration

### Multi-tenancy
The application supports multiple tenants. Each tenant has:
- Separate database (optional)
- Isolated data
- Custom settings
- Independent users

### Stock Costing
Two costing methods are supported:
- **FIFO**: First In, First Out
- **Average**: Weighted average cost

### Units
Supported measurement units:
- `piece` - Individual items
- `m` - Linear meters
- `m²` - Square meters
- `m³` - Cubic meters
- `sheet` - Sheet materials

## Deployment

### Production Setup
1. Set up a production server (Ubuntu 20.04+ recommended)
2. Install PHP 8.0+, MySQL/PostgreSQL, Nginx
3. Clone the repository
4. Install dependencies: `composer install --no-dev`
5. Configure environment variables
6. Run migrations and seeders
7. Set up SSL certificates
8. Configure web server (Nginx/Apache)
9. Set up queue workers for background jobs
10. Configure backup procedures

### Docker Deployment
```bash
# Build and run with Docker Compose
docker-compose up -d

# Run migrations
docker-compose exec app php artisan migrate

# Seed database
docker-compose exec app php artisan db:seed
```

## Monitoring and Maintenance

### Logs
- Application logs: `storage/logs/laravel.log`
- Activity logs: `activity_log` table
- Error tracking: Configure with services like Sentry

### Backup
- Database backups: Daily automated backups
- File storage: Regular backup of uploaded files
- Configuration: Backup of `.env` and configuration files

### Performance
- Enable Redis for caching and sessions
- Use queue workers for heavy operations
- Monitor database performance
- Implement CDN for static assets

## Contributing

1. Fork the repository
2. Create a feature branch: `git checkout -b feature/new-feature`
3. Make your changes
4. Add tests for new functionality
5. Run tests: `php artisan test`
6. Commit changes: `git commit -am 'Add new feature'`
7. Push to branch: `git push origin feature/new-feature`
8. Submit a pull request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Support

For support and questions:
- Email: support@woodtrading.com
- Documentation: [API Documentation](API_DOCUMENTATION.md)
- Issues: [GitHub Issues](https://github.com/your-username/wood-trading/issues)

## Changelog

### Version 1.0.0
- Initial release
- Complete inventory management
- Sales and purchase workflows
- Multi-tenant support
- RESTful API with Swagger documentation
- Comprehensive testing suite
- Role-based access control
- Financial reporting
- PDF generation
- Audit logging

## Roadmap

### Version 1.1.0
- [ ] Mobile app (React Native)
- [ ] Advanced reporting dashboard
- [ ] Barcode scanning integration
- [ ] Email notifications
- [ ] Advanced inventory forecasting

### Version 1.2.0
- [ ] Multi-currency support
- [ ] Advanced pricing rules
- [ ] Integration with accounting software
- [ ] Advanced analytics and insights
- [ ] Workflow automation

---

**Note**: This is a comprehensive wood trading management system designed for small to medium-sized businesses. The system handles the complete workflow from inventory management to financial operations, with a focus on ease of use and scalability.