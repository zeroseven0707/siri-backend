# Icon Mapping Documentation

## Overview
Service icons are **hardcoded** in the mobile app based on the service `slug` field. This means icons are NOT uploaded through the admin panel.

## How It Works

### Backend
- The `icon` field in the `services` table is **not used** by the mobile app
- The API (`ServiceResource`) does NOT return the `icon` field
- Admin panel does NOT have icon upload fields

### Mobile App
Icons are mapped based on the service `slug` in multiple files:
- `push-mobile/app/(tabs)/home.tsx`
- `push-mobile/components/ServiceCard.tsx`
- `push-mobile/app/(tabs)/orders.tsx`
- `push-mobile/app/orders-list.tsx`

## Home Section Items (Service List)

When creating home section items with `action_type: 'service'`:
- **action_value** should contain the service **slug** (e.g., `food`, `ojek`, `car`)
- **NOT** the service UUID
- The mobile app uses this slug to look up the icon from the hardcoded mapping
- **image** field is ignored for service items (set to null)

Example in admin panel:
```
Title: Pesan Makanan
Action Type: service
Action Value: food  ← Use slug, not UUID
```

## Current Icon Mapping

| Slug | Icon | Color | Background |
|------|------|-------|------------|
| `food` | Utensils/UtensilsCrossed | #F97316 (Orange) | #FFF7ED |
| `ojek` | Bike | #2ECC71 (Green) | #F0FDF4 |
| `car` | Car | #3B82F6 (Blue) | #EFF6FF |
| `mobil` | Car | #3B82F6 (Blue) | #EFF6FF |
| `delivery` | Package | #A855F7 (Purple) | #FAF5FF |
| `nitah` | HandHelping | #EC4899 (Pink) | #FDF2F8 |

## Adding New Services

### Step 1: Add to Database
Create a new service in the admin panel with a unique `slug`. Example slugs:
- `food`, `ojek`, `car`, `mobil`, `delivery`, `nitah`

### Step 2: Add Icon Mapping in Mobile App
Update the icon mappings in these files:

**1. `push-mobile/app/(tabs)/home.tsx`**
```typescript
const SERVICE_ICONS: Record<string, { icon: any; color: string; bg: string }> = {
  // ... existing mappings
  your_slug: { icon: YourIcon, color: '#HEX_COLOR', bg: '#BG_COLOR' },
};
```

**2. `push-mobile/components/ServiceCard.tsx`**
```typescript
const SERVICE_ICONS: Record<string, any> = {
  // ... existing mappings
  your_slug: YourIcon,
};
const SERVICE_COLORS: Record<string, string> = {
  // ... existing mappings
  your_slug: '#BG_COLOR',
};
const ICON_COLORS: Record<string, string> = {
  // ... existing mappings
  your_slug: '#ICON_COLOR',
};
```

**3. `push-mobile/app/(tabs)/orders.tsx`** (same structure as ServiceCard.tsx)

**4. `push-mobile/app/orders-list.tsx`**
```typescript
const SERVICE_ICON_MAP: Record<string, any> = {
  // ... existing mappings
  your_slug: YourIcon,
};
```

### Step 3: Import Icon
Make sure to import the icon from `lucide-react-native`:
```typescript
import { YourIcon } from 'lucide-react-native';
```

## Important Notes

1. **Slug is the Key**: The `slug` field must match exactly with the mapping keys
2. **Name Can Change**: Admin can change the service name without affecting icons
3. **Slug Should NOT Change**: Once a service is created, its slug should remain constant
4. **Default Icon**: If a slug is not found in the mapping, a default Grid icon will be shown
5. **Icon Upload Removed**: The admin panel no longer has icon upload functionality

## Example: Adding a New "Laundry" Service

1. Create service in admin with slug: `laundry`
2. Add to mobile mappings:
```typescript
// Import
import { Shirt } from 'lucide-react-native';

// Mapping
laundry: { icon: Shirt, color: '#06B6D4', bg: '#ECFEFF' }
```
3. Deploy mobile app update

## Troubleshooting

**Problem**: Icon not showing after changing service name
**Solution**: Icons are based on `slug`, not `name`. Check if the slug matches the mapping.

**Problem**: New service shows default Grid icon
**Solution**: Add the service slug to all icon mapping files in the mobile app.

**Problem**: Want to change icon for existing service
**Solution**: Update the icon mapping in the mobile app code and redeploy.
