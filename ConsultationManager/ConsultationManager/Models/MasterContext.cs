using System;
using System.Collections.Generic;
using Microsoft.EntityFrameworkCore;

namespace ConsultationManager.Models;

public partial class MasterContext : DbContext
{
  public MasterContext()
  {
    //Database.Migrate();
  }

  public MasterContext(DbContextOptions<MasterContext> options)
      : base(options)
  {
    //Database.Migrate();
  }

  public virtual DbSet<Patient> Patients { get; set; }
  public virtual DbSet<Doctor> Doctors { get; set; }
  public virtual DbSet<Admin> Admins { get; set; }
  public virtual DbSet<Consultation> Consultations { get; set; }
  public DbSet<Audit> AuditLogs { get; set; }

  public virtual void SaveChanges(string userEmail)
  {
    BeforeSaveChanges(userEmail);
    base.SaveChanges();
  }
  private void BeforeSaveChanges(string userId)
  {
    ChangeTracker.DetectChanges();
    var auditEntries = new List<AuditEntry>();
    foreach (var entry in ChangeTracker.Entries())
    {
      if (entry.Entity is Audit || entry.State == EntityState.Detached || entry.State == EntityState.Unchanged)
        continue;
      var auditEntry = new AuditEntry(entry);
      auditEntry.TableName = entry.Entity.GetType().Name;
      auditEntry.UserId = userId;
      auditEntries.Add(auditEntry);
      foreach (var property in entry.Properties)
      {
        string propertyName = property.Metadata.Name;
        if (property.Metadata.IsPrimaryKey())
        {
          auditEntry.KeyValues[propertyName] = property.CurrentValue;
          continue;
        }
        switch (entry.State)
        {
          case EntityState.Added:
            auditEntry.AuditType = AuditType.Create;
            auditEntry.NewValues[propertyName] = property.CurrentValue;
            break;
          case EntityState.Deleted:
            auditEntry.AuditType = AuditType.Delete;
            auditEntry.OldValues[propertyName] = property.OriginalValue;
            break;
          case EntityState.Modified:
            if (property.IsModified)
            {
              auditEntry.ChangedColumns.Add(propertyName);
              auditEntry.AuditType = AuditType.Update;
              auditEntry.OldValues[propertyName] = property.OriginalValue;
              auditEntry.NewValues[propertyName] = property.CurrentValue;
            }
            break;
        }
      }
    }
    foreach (var auditEntry in auditEntries)
    {
      AuditLogs.Add(auditEntry.ToAudit());
    }
  }


  protected override void OnConfiguring(DbContextOptionsBuilder optionsBuilder)
#warning To protect potentially sensitive information in your connection string, you should move it out of source code. You can avoid scaffolding the connection string by using the Name= syntax to read it from configuration - see https://go.microsoft.com/fwlink/?linkid=2131148. For more guidance on storing connection strings, see http://go.microsoft.com/fwlink/?LinkId=723263.
  //=> optionsBuilder.UseSqlServer("Server = (localdb)\\MSSQLLocalDB;Integrated Security = True; Connect Timeout = 30; Encrypt=False;TrustServerCertificate=True;ApplicationIntent=ReadWrite;MultiSubnetFailover=False");
  //=> optionsBuilder.UseSqlServer(@"Server = db; Database = consultation_db; User = sa; Password = Docker123!; TrustServerCertificate=True;");
  //=> optionsBuilder.UseSqlServer("Server = backend; Database = master; User = sa; Password = Docker123!; TrustServerCertificate=true; encrypt=false;");
  => optionsBuilder.UseSqlServer("Server = (localdb)\\MSSQLLocalDB; Database = master; TrustServerCertificate=true; encrypt=false;");

  protected override void OnModelCreating(ModelBuilder modelBuilder)
  {
    OnModelCreatingPartial(modelBuilder);
  }

  partial void OnModelCreatingPartial(ModelBuilder modelBuilder);

}
