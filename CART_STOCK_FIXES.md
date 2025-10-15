# Cart and Stock Issues - Fixes Applied

## Issues Identified and Fixed

### 1. Stock Display Issue
**Problem**: Products were showing as "out of stock" even when they had stock available.

**Root Cause**: The `inStock()` scope was only checking the `in_stock` boolean field, which wasn't being properly updated based on actual stock quantities.

**Fixes Applied**:
- Updated `Product` model's `scopeInStock()` method to properly handle both managed and unmanaged stock
- Added `getIsInStockAttribute()` accessor to dynamically calculate stock status
- Updated `ProductResource` and `ProductDetailResource` to use the new stock logic
- Removed `inStock()` filter from product listings to show all active products

### 2. Add to Cart Not Working
**Problem**: Items weren't being added to cart properly.

**Root Causes**:
- Session handling issues for API routes
- Insufficient stock validation logic
- Missing session persistence

**Fixes Applied**:
- Added `web` middleware to cart routes for proper session handling
- Improved stock validation in `CartController::store()` method
- Added `session()->save()` to force session persistence
- Enhanced error messages for better user feedback
- Added cart count in response for immediate UI updates

## Key Changes Made

### 1. Product Model (`app/Models/Product.php`)
```php
// New stock scope that handles both managed and unmanaged stock
public function scopeInStock($query)
{
    return $query->where(function($q) {
        $q->where('manage_stock', false)
          ->orWhere(function($subQ) {
              $subQ->where('manage_stock', true)
                   ->where('stock_quantity', '>', 0);
          });
    });
}

// New accessor for dynamic stock status
public function getIsInStockAttribute()
{
    if (!$this->manage_stock) {
        return true;
    }
    return $this->stock_quantity > 0;
}
```

### 2. Cart Controller (`app/Http/Controllers/API/CartController.php`)
- Enhanced stock validation
- Better error handling
- Forced session persistence
- Added cart count in responses

### 3. API Routes (`routes/api.php`)
```php
// Added web middleware for session support
Route::prefix('cart')->middleware(['web'])->group(function () {
    // ... cart routes
});
```

### 4. Product Resources
- Updated to use new `is_in_stock` accessor
- Added `manage_stock` and `stock_quantity` fields for frontend logic

## Testing

Run the test script to verify fixes:
```bash
php test_cart_fix.php
```

## Expected Behavior After Fixes

1. **Stock Display**: Products will show correct stock status based on:
   - If `manage_stock` is false: Always show as "in stock"
   - If `manage_stock` is true: Show "in stock" only if `stock_quantity > 0`

2. **Add to Cart**: 
   - Works properly with session persistence
   - Validates stock before adding
   - Provides clear error messages
   - Returns cart count for UI updates

3. **Product Listings**: Show all active products regardless of stock (let frontend handle stock display)

## Frontend Integration Notes

The API now provides these fields for proper stock handling:
- `in_stock`: Boolean indicating if item is available
- `stock_quantity`: Actual quantity available
- `manage_stock`: Whether stock is managed for this product

Frontend should:
1. Check `in_stock` to show/hide "Add to Cart" button
2. Use `stock_quantity` to show quantity available
3. Handle cart responses for immediate UI feedback